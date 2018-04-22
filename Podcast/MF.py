
# coding: utf-8

# In[29]:


# Generate a matrix

import pandas as pd
from numpy import *
import numpy
import csv
import mysql.connector


print 'aaaaaaaaaaaaaaaaa'

cnx = mysql.connector.connect(user='root', database='podcast', password="")
cursor = cnx.cursor()

query = ("SELECT %s from %s;")

cursor.execute(query%("count(user_id)","users"))
users_count = int(cursor.fetchone()[0])

cursor.execute(query%("count(pd_id)","podcasts"))
podcasts_count = int(cursor.fetchone()[0])

utility_matrix = numpy.zeros((users_count, podcasts_count))

cursor.execute(query%("*","user_pd_mp"))
for (user_id,pd_id, likes) in cursor:
    utility_matrix[int(user_id)-1][int(pd_id)-1]+=1
#utility_matrix = numpy.array(list(csv.reader(open("answer.csv", "rb"), delimiter=","))).astype("float")
print utility_matrix.shape


# In[28]:



print numpy.linalg.matrix_rank(utility_matrix)


# In[31]:


users, pods = utility_matrix.shape
r=50                #number of latent factors
ita=0.01            #learning rate
beta=0.01          #regularization constant
epoch=50           #number of iterations
alpha = 2         #value in confidence equation

print users,pods

# Initialize latent factor matrice
P = numpy.random.normal(scale=1.0/r, size=(users, r))
Q = numpy.random.normal(scale=1.0/r, size=(pods, r))
confidence = numpy.zeros((users, pods))
preference = numpy.zeros((users, pods))

print 'ssssssssssssssssss'
# In[32]:


#create training data

training_data = []

for i in range(users):
    for j in range(pods):
        if utility_matrix[i][j] > 0:
            training_data.append((i,j))
            preference[i][j] = 1.0
            confidence[i][j] = 1.0 + alpha*utility_matrix[i][j]

print "Done!"


# In[33]:


cost = []

for k in range(epoch):
    numpy.random.shuffle(training_data)
    
    ### Stocastic Gradient Descent
    for i,j in training_data:
        predicted_rating = numpy.dot(P[i, :],Q[j, :].T)
        error = preference[i][j] - predicted_rating
        
        P[i, :] += (2*ita*confidence[i][j]*error*Q[j, :] - ita*beta*P[i, :])
        Q[j, :] += (2*ita*confidence[i][j]*error*P[i, :] - ita*beta*Q[j, :])

    ### SSE
    # finding value of J(w) i.e. optimization function
    x_list, y_list = utility_matrix.nonzero()
    predicted = numpy.dot(P,Q.T)
    error = 0
    for x, y in zip(x_list, y_list):
        error += confidence[x][y]*pow(preference[x][y] - predicted[x][y], 2)
    numpy.sqrt(error)
    cost.append((k,error))


# In[34]:


prediction = numpy.dot(P,Q.T)
print prediction.shape
print prediction

cnx = mysql.connector.connect(user='root', database='podcast', password="")
cursor = cnx.cursor()
count = 1
cursor.execute("delete from user_reco")
for row in prediction:
    reco = numpy.argsort(row)[::-1][:25]
    rec_no = 0
    for entry in reco:
		if utility_matrix[count - 1][entry] == 0:
			query = "INSERT INTO user_reco values %s"
			print query%("("+str(count)+","+str(entry+1)+")")
			cursor.execute(query%("("+str(count)+","+str(entry+1)+")"))
			rec_no+=1
		if rec_no == 12:
			break
    count +=1

print 'ssssssssssssssssssssssssssssssssssssssssssssssssssssss'
cursor.close()
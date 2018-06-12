#include "/home/sguha/Desktop/gcov_test/lib_next/fooclass.h"
#include <iostream>

using namespace std;

int main(int argc, char const *argv[])
{
    FooClass * fooClass = new FooClass();

    cout<< fooClass->SayHello() << endl;

    return 0;
}

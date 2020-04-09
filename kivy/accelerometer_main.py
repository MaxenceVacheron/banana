from time import sleep
from jnius import MetaJavaClass, JavaClass, JavaMethod, JavaStaticMethod

class Hardware(JavaClass):
    __metaclass__ = MetaJavaClass
    __javaclass__ = 'org/renpy/android/Hardware'
    vibrate = JavaStaticMethod('(D)V')
    accelerometerEnable = JavaStaticMethod('(Z)V')
    accelerometerReading = JavaStaticMethod('()[F')
    getDPI = JavaStaticMethod('()I')
    
# use that new class!
print('DPI is', Hardware.getDPI())

Hardware.accelerometerEnable()
for x in xrange(20):
    print(Hardware.accelerometerReading())
    sleep(.1)
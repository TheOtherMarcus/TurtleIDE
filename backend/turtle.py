import pigpio

pi = pigpio.pi()

def jog(steps):
    for i in range(1, steps):
	pi.write(17, i%2)
	pi.write(27, i%2)

def b(mm):
    f(-mm)

def f(mm):
    if mm < 0:
        pi.write(18, 0);
        pi.write(22, 1);
    else:
        pi.write(18, 1);
        pi.write(22, 0);
    jog(10*abs(mm))

def l(angle):
    v(angle)

def v(angle):
    if angle < 0:
        pi.write(18, 1);
        pi.write(22, 1);
    else:
        pi.write(18, 0);
        pi.write(22, 0);
    angle = abs(angle)
    while angle > 360:
	angle -= 360        
    steps = int(angle*3340/180)
    jog(steps)

def r(angle):
    h(angle)

def h(angle):
    if angle < 0:
        pi.write(18, 0);
        pi.write(22, 0);
    else:
        pi.write(18, 1);
        pi.write(22, 1);
    angle = abs(angle)
    while angle > 360:
	angle -= 360   
    steps = int(angle*3340/180)
    jog(steps)

def u():
    p(0)

def n():
    p(1)

def d():
    p(1)

def p(down):
    if down:
        pi.set_servo_pulsewidth(4, 1400)
    else:
        pi.set_servo_pulsewidth(4, 1700)

# Lift pen
p(0)

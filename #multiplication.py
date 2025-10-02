#multiplication
class Shooting:
     def __init__(self,trigger,bullet ):
          self.trigger=trigger 
          self.bullet=bullet 
     def shoot(self):
          if self.trigger=="pressed":
               for x in range(0,5):
                    print('💣',x+1,self.bullet)
          else:
               print('change the magazine ')
                              
gun=Shooting('pressed','9mm barreta')   
gun.shoot()  
import sys

while True:
    count = int(input())  # Read the number of enemies
    closest_enemy = None
    min_dist = float('inf')
    
    for _ in range(count):
        name = input()
        dist = int(input())
        if dist < min_dist:
            min_dist = dist
            closest_enemy = name
            
    print(closest_enemy)
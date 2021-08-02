#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Step 4/4
Created on Wed Jul 28 19:52:05 2021
Process the the file "allmean.csv" generated in step 3
and cleans it (orders it and remove repeated dates).
Saves the clean time series as 'allmean_clean.csv'
Generates a plot of the time series
@author: eduardo
"""

import pandas as pd
import os
import matplotlib.pyplot as plt


#Speciy the route directory where the file "allmean.csv" 
#(generated in step3) is
route= "/home/eduardo/Documents/PhD_UoA/ML_paper/nexttides/prueba_nexttides/"

filename="allmean.csv"
os.chdir(route)

df=pd.read_csv(filename,header=None)
df.columns= ["Date","value"]
#Set dates as DF index
df.set_index('Date', inplace=True)
df=df.astype(float)
#Order the array
df = df.sort_index()
#remove duplicates, keep first
df = df[~df.index.duplicated(keep='first')]
df.index = pd.DatetimeIndex(df.index)

fig,ax = plt.subplots()
df.plot(ax=ax)
plt.title("Mean daily tide")
plt.savefig("Mean_daily_tide.png")
df.to_csv('allmean_clean.csv', index=True,header=False)
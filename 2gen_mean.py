#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Step 2/4
Created on Thu Jul 29 13:39:41 2021
Process the hourly tide .csv retrieved with 1retrievetides.php
and saves a daily mean .csv time series 

@author: e.eduardo gomez de la pena
"""

import pandas as pd
import os; import csv
import numpy as np
import glob

#Specify years to loop
years=["2010","2011"]
#Speciy the main directory where years subdirectories are
maindir= "/home/eduardo/Documents/PhD_UoA/ML_paper/nexttides/prueba_nexttides/"


for year in years:
    
    route= maindir+year
    #filename="1999-02-01_tide_NIWA.csv"
    os.chdir(route)

    for file in glob.glob('*tide*.csv'):
    
        with open(file, newline='') as csvfile:
            data = list(csv.reader(csvfile, delimiter=','))
        print("processing:"+file)
        data= data[0]
        #Cut header information
        matching = [s for s in data if "values" in s]
        idx_headcut= data.index(matching[0])
        data= data[idx_headcut:]

        #Check for rows that have time string 
        matching_time = [data.index(s) for s in data if "time" in s]

        #Check for rows that have values
        matching_values = [data.index(s) for s in data if "value:" in s]

        start = 'time":"'
        end = ':'

        time_col=np.empty([len(matching_time),2], dtype=object)
        for i in range(len(matching_time)):
            result = (data[matching_time[i]].split(start))[1].split(end)[0]
            time_col[i,0]=result

        start = 'value:'
        end = '}'

        for i in range(len(matching_values)):
            result = (data[matching_values[i]].split(start))[1].split(end)[0]
            time_col[i,1]=result

        ord_df= pd.DataFrame(time_col[:,1], index= pd.to_datetime(time_col[:,0]))
        ord_df.columns= ["value"]

        ord_df=ord_df.astype(float)

        df_mean=ord_df.resample('D').mean()

        df_mean.to_csv(file[0:11]+'mean.csv', index=True,header=False)
        print("Saving "+file[0:11]+'mean.csv')

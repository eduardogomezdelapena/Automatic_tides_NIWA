



#!/bin/bash
# Step 3/4
# Concat all daily mean .csv time series into "all_mean.csv"
# run 
# bash ./3cat_to_singlets.sh 

find . -type f -name '*mean.csv' -exec cat {} + >allmean.csv

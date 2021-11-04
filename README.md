# Automatic_tides_NIWA
Scripts for automatic download of NIWA tide forecast, New Zealand.
No support is provided.

Each script (4) has its own description, please read it 
to ensure the requirements for each script are fulfilled.

Once in an empty directory,
the scripts must be run in sequence from linux bash:

	php 1retrievetides.php
	python 2gen_mean.py
	bash 3cat_to_singlets.sh
	python 4merge_allmean_series.py


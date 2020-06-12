#!/bin/bash

# ms_defender controller
CTL="${BASEURL}index.php?/module/ms_defender/"

# Get the scripts in the proper directories
"${CURL[@]}" "${CTL}get_script/ms_defender.py" -o "${MUNKIPATH}preflight.d/ms_defender.py"

# Check exit status of curl
if [ $? = 0 ]; then
	# Make executable
	chmod a+x "${MUNKIPATH}preflight.d/ms_defender.py"

	# Set preference to include this file in the preflight check
	setreportpref "ms_defender" "${CACHEPATH}ms_defender.plist"

else
	echo "Failed to download all required components!"
	rm -f "${MUNKIPATH}preflight.d/ms_defender.py"

	# Signal that we had an error
	ERR=1
fi

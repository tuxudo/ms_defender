#!/bin/bash

# Remove ms_defender script
rm -f "${MUNKIPATH}preflight.d/ms_defender.py"

# Remove ms_defender.plist file
rm -f "${MUNKIPATH}preflight.d/cache/ms_defender.plist"

#!/usr/local/munkireport/munkireport-python3

import os
import subprocess
import sys
import plistlib
import re
import string
import datetime
import time


def get_mdatp_data():

    cmd = ['/usr/local/bin/mdatp', 'health']
    proc = subprocess.Popen(cmd, shell=False, bufsize=-1,
                            stdin=subprocess.PIPE,
                            stdout=subprocess.PIPE, stderr=subprocess.PIPE)
    (output, unused_error) = proc.communicate()

    out = {}

    for item in output.decode().split('\n'):
        if 'cloudAutomaticSampleSubmission     ' in item:
            out['cloud_automatic_sample_submission'] = to_bool(item.split(" : ")[1].strip())
        elif 'cloudDiagnosticEnabled     ' in item:
            out['cloud_diagnostic_enabled'] = to_bool(item.split(" : ")[1].strip())
        elif 'cloudEnabled     ' in item:
            out['cloud_enabled'] = to_bool(item.split(" : ")[1].strip())
        elif 'definitionsUpdated     ' in item:
            out['definitions_updated'] = re.sub('[^0-9]','', item.split(" : ")[1].strip())
        elif 'definitionsVersion     ' in item:
            out['definitions_version'] = re.sub('[^0-9]','', item.split(" : ")[1].strip())
        elif 'licensed     ' in item:
            out['licensed'] = to_bool(item.split(" : ")[1].strip())
        elif 'logLevel     ' in item:
            out['log_level'] = remove_all('"', item.split(" : ")[1].strip())
        elif 'realTimeProtectionAvailable     ' in item:
            out['real_time_protection_available'] = to_bool(item.split(" : ")[1].strip())
        elif 'realTimeProtectionEnabled     ' in item:
            out['real_time_protection_enabled'] = to_bool(item.split(" : ")[1].strip())
        elif 'healthy     ' in item:
            out['healthy'] = to_bool(item.split(" : ")[1].strip())
        elif 'edrEarlyPreviewEnabled     ' in item:
            out['erd_early_preview_enabled'] = to_bool(item.split(" : ")[1].strip())
        elif 'releaseRing     ' in item:
            out['release_ring'] = remove_all('"', item.split(" : ")[1].strip())
        elif 'versionEngine     ' in item:
            out['app_version'] = remove_all('"', item.split(" : ")[1].strip())
        elif 'edrMachineId     ' in item:
            out['erd_machine_id'] = remove_all('"', item.split(" : ")[1].strip())
        elif 'machineGuid     ' in item:
            out['machine_guid'] = remove_all('"', item.split(" : ")[1].strip())
        elif 'orgId     ' in item:
            out['org_id'] = remove_all('"', item.split(" : ")[1].strip())
        elif 'appVersion     ' in item:
            out['app_version'] = remove_all('"', item.split(" : ")[1].strip())
        elif 'cloudAutomaticSampleSubmissionConsent   ' in item:
            out['cloud_auto_sample_submission_consent'] = remove_all('"', item.split(" : ")[1].strip())
        elif 'engineVersion      ' in item:
            out['engine_version'] = remove_all('"', item.split(" : ")[1].strip())
        elif 'realTimeProtectionSubsystem     ' in item:
            out['real_time_protection_subsystem'] = remove_all('"', item.split(" : ")[1].strip())
        # Below are definitions used by Defender 101.19.48+
        elif 'app_version     ' in item:
            out['app_version'] = remove_all('"', item.split(" : ")[1].strip())
        elif 'automatic_definition_update_enabled     ' in item:
            out['automatic_definition_update_enabled'] = to_bool(item.split(" : ")[1].strip())
        elif 'cloud_automatic_sample_submission_consent   ' in item:
            out['cloud_auto_sample_submission_consent'] = remove_all('"', item.split(" : ")[1].strip())
        elif 'cloud_diagnostic_enabled     ' in item:
            out['cloud_diagnostic_enabled'] = to_bool(item.split(" : ")[1].strip())
        elif 'cloud_enabled     ' in item:
            out['cloud_enabled'] = to_bool(item.split(" : ")[1].strip())
        elif 'definitions_updated     ' in item:
            date_time_obj = datetime.datetime.strptime(item.split(" : ")[1].strip(), '%b %d, %Y at %I:%M:%S %p')
            out['definitions_updated'] = int(time.mktime(date_time_obj.timetuple()))*1000
        elif 'definitions_version     ' in item:
            out['definitions_version'] = re.sub('[^0-9]','', item.split(" : ")[1].strip())
        elif 'edr_early_preview_enabled     ' in item:
            out['erd_early_preview_enabled'] = to_bool(item.split(" : ")[1].strip())
        elif 'edr_machine_id     ' in item:
            out['erd_machine_id'] = remove_all('"', item.split(" : ")[1].strip())
        elif 'engine_version      ' in item:
            out['engine_version'] = remove_all('"', item.split(" : ")[1].strip())
        elif 'healthy     ' in item:
            out['healthy'] = to_bool(item.split(" : ")[1].strip())
        elif 'licensed     ' in item:
            out['licensed'] = to_bool(item.split(" : ")[1].strip())
        elif 'log_level     ' in item:
            out['log_level'] = remove_all('"', item.split(" : ")[1].strip())
        elif 'machine_guid     ' in item:
            out['machine_guid'] = remove_all('"', item.split(" : ")[1].strip())
        elif 'org_id     ' in item:
            out['org_id'] = remove_all('"', item.split(" : ")[1].strip())
        elif 'real_time_protection_available     ' in item:
            out['real_time_protection_available'] = to_bool(item.split(" : ")[1].strip())
        elif 'real_time_protection_enabled     ' in item:
            out['real_time_protection_enabled'] = to_bool(item.split(" : ")[1].strip())
        elif 'real_time_protection_subsystem     ' in item:
            out['real_time_protection_subsystem'] = remove_all('"', item.split(" : ")[1].strip())
        elif 'release_ring     ' in item:
            out['release_ring'] = remove_all('"', item.split(" : ")[1].strip())
    return out


def to_bool(s):
    if s == True or "true" in s or "enabled" in s:
        return 1
    else:
        return 0

def remove_all(substr, string):
    try:
        removed = string.replace(substr, "")
    except:
        removed = string.replace(substr.encode("utf-8"), "".encode())
    return removed

def main():
    """Main"""

    # Check if ms defender is installed
    if  not os.path.isfile('/usr/local/bin/mdatp'):
        print("ERROR: Microsoft Defender is not installed")
        exit(0)

    # Get information about Microsoft Defender    
    result = get_mdatp_data()

    # Write results to cache
    cachedir = '%s/cache' % os.path.dirname(os.path.realpath(__file__))
    output_plist = os.path.join(cachedir, 'ms_defender.plist')
    try:
        plistlib.writePlist(result, output_plist)
    except:
        with open(output_plist, 'wb') as fp:
            plistlib.dump(result, fp, fmt=plistlib.FMT_XML)
#    print plistlib.writePlistToString(result)

if __name__ == "__main__":
    main()

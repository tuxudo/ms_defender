#!/usr/bin/python

import os
import subprocess
import sys
import plistlib
import re
import string


def get_mdatp_data():
    
    cmd = ['/usr/local/bin/mdatp', '--health']
    proc = subprocess.Popen(cmd, shell=False, bufsize=-1,
                            stdin=subprocess.PIPE,
                            stdout=subprocess.PIPE, stderr=subprocess.PIPE)
    (output, unused_error) = proc.communicate()
        
    out = {}
    
    for item in output.split('\n'):
        if 'cloudAutomaticSampleSubmission          : ' in item:
            out['cloud_automatic_sample_submission'] = to_bool(remove_all('cloudAutomaticSampleSubmission          : ', item).strip())
        elif 'cloudDiagnosticEnabled                  : ' in item:
            out['cloud_diagnostic_enabled'] = to_bool(remove_all('cloudDiagnosticEnabled                  : ', item).strip())
        elif 'cloudEnabled                            : ' in item:
            out['cloud_enabled'] = to_bool(remove_all('cloudEnabled                            : ', item).strip())
        elif 'definitionsUpdated                      : ' in item:
            out['definitions_updated'] = re.sub('[^0-9]','', remove_all('definitionsUpdated                      : ', item).strip())
        elif 'definitionsVersion                      : ' in item:
            out['definitions_version'] = re.sub('[^0-9]','', remove_all('definitionsVersion                      : ', item).strip())
        elif 'licensed                                : ' in item:
            out['licensed'] = to_bool(remove_all('licensed                                : ', item).strip())
        elif 'logLevel                                : ' in item:
            out['log_level'] = remove_all('"', remove_all('logLevel                                : ', item).strip())
        elif 'realTimeProtectionAvailable             : ' in item:
            out['real_time_protection_available'] = to_bool(remove_all('realTimeProtectionAvailable             : ', item).strip())
        elif 'realTimeProtectionEnabled               : ' in item:
            out['real_time_protection_enabled'] = to_bool(remove_all('realTimeProtectionEnabled               : ', item).strip())
        elif 'healthy                                 : ' in item:
            out['healthy'] = to_bool(remove_all('healthy                                 : ', item).strip())
        elif 'edrEarlyPreviewEnabled                  : ' in item:
            out['erd_early_preview_enabled'] = to_bool(remove_all('edrEarlyPreviewEnabled                  : ', item).strip())
        elif 'releaseRing                             : ' in item:
            out['release_ring'] = remove_all('"', remove_all('releaseRing                             : ', item).strip())
        elif 'versionEngine                           : ' in item:
            out['engine_version'] = remove_all('"', remove_all('versionEngine                           : ', item).strip())
        elif 'edrMachineId                            : ' in item:
            out['erd_machine_id'] = remove_all('"', remove_all('edrMachineId                            : ', item).strip())
        elif 'machineGuid                             : ' in item:
            out['machine_guid'] = remove_all('"', remove_all('machineGuid                             : ', item).strip())
        elif 'orgId                                   : ' in item:
            out['org_id'] = remove_all('"', remove_all('orgId                                   : ', item).strip())
    
    return out

    
def to_bool(s):
    if s == True or "true" in s or "enabled" in s:
        return 1
    else:
        return 0

def remove_all(substr, str):
    index = 0
    length = len(substr)
    while string.find(str, substr) != -1:
        index = string.find(str, substr)
        str = str[0:index] + str[index+length:]
    return str

def main():
    """Main"""
            
    # Check if ms defender is installed
    if  not os.path.isfile('/usr/local/bin/mdatp'):
        print "ERROR: Microsoft Defender is not installed"
        exit(0)

    # Get information about Microsoft Defender    
    result = get_mdatp_data()
    
    # Write results to cache
    cachedir = '%s/cache' % os.path.dirname(os.path.realpath(__file__))
    output_plist = os.path.join(cachedir, 'ms_defender.plist')
    plistlib.writePlist(result, output_plist)
    #print plistlib.writePlistToString(result)

if __name__ == "__main__":
    main()

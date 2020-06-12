<?php

use CFPropertyList\CFPropertyList;
use munkireport\processors\Processor;

class Ms_defender_processor extends Processor
{
    public function run($plist)
    {
        // Check if we have data
		if ( ! $plist){
			throw new Exception("Error Processing Request: No property list found", 1);
		}

        $parser = new CFPropertyList();
        $parser->parse($plist, CFPropertyList::FORMAT_XML);
        $mylist = $parser->toArray();

        $model = Ms_defender_model::firstOrNew(['serial_number' => $this->serial_number]);

        $model->fill($mylist);
        $model->save();
    }   
}

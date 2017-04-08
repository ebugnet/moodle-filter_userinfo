<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

defined('MOODLE_INTERNAL') || die();

class filter_userinfo extends moodle_text_filter {

    public function filter($text, array $options = array()) {
        global $CFG,$COURSE,$USER,$PAGE,$OUTPUT;
        if (!is_string($text) or empty($text)) {
            // Non-string data can not be filtered anyway.
            return $text;
        }

        if (strpos($text, '[USER:') === false) {
            // Stop if no job to do
            return $text;
        }	

        if ($PAGE->user_is_editing()) {
            // Don't filter text in editing mod
            return $text;
        }

        // Prepare replacements
        $i = 0;
        $patterns = array();
        $replacements = array();

        foreach ($USER as $key => $value) {

            if ($key != 'loginascontext') {
                if (!is_array($value)) {
                    if ($key == 'picture') {
                        $patterns[$i] = '/\[USER:'.$key.'\]/';
                        $replacements[$i] = $OUTPUT->user_picture($USER, array('courseid' => $COURSE->id, 'link' => true));
                    } else {		        
                        $patterns[$i] = '/\[USER:'.$key.'\]/';
                        $replacements[$i] = $value;
                    }

                } elseif ($key == 'profile') {
                    // Personnalised datas
                    foreach ($value as $pkey => $pvalue) {
                        $patterns[$i] = '/\[USER:profile_'.$pkey.'\]/';
                        $replacements[$i] = $pvalue;
                    } 

                } elseif ($key == 'groupmember' && !empty($key) && $groups = groups_get_user_groups($COURSE->id, $USER->id)) {                
                                             
                        foreach ($groups as $group) {

                            if (isset($group[0])) {
                                $groupid = $group[0];

                                $patterns[$i] = '/\[USER:group_id\]/';
                                $replacements[$i] = $groupid;
                                $i++;

                                $patterns[$i] = '/\[USER:group_name\]/';
                                $replacements[$i] = groups_get_group_name($groupid);
                                $i++;

                                // Get picture
                                $group_data = groups_get_group($groupid, $fields='*', $strictness=IGNORE_MISSING) ;
                                $patterns[$i] = '/\[USER:group_picture\]/';
                                $replacements[$i] = print_group_picture($group_data, $COURSE->id, false, true, true);
                                $i++;
                                $patterns[$i] = '/\[USER:group_picture_large\]/';
                                $replacements[$i] = print_group_picture($group_data, $COURSE->id, true, true, true);  
                            } else {
 
                                $patterns[$i] = '/\[USER:group_id\]/';
                                $replacements[$i] = '';
                                $i++;

                                $patterns[$i] = '/\[USER:group_name\]/';
                                $replacements[$i] = '';
                                $i++;

                                $patterns[$i] = '/\[USER:group_picture\]/';
                                $replacements[$i] = '';
                                $i++;
                                $patterns[$i] = '/\[USER:group_picture_large\]/';
                                $replacements[$i] = '';  
                           
                            
                            
                            
                            
                            
                            }                           
                        }
                    //}
                }
            }
            $i++;
        }

        ksort($patterns);
        ksort($replacements);

        return preg_replace($patterns, $replacements, $text);
    }
}
?>

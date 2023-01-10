<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

$fh=fopen("./dhcpd.leases","r");
$leases = array();
while ($dat=fgets($fh)) // Loop over each line in the leases file
{
        $dat = preg_replace('@^(\s|\t){1,9}|;$@','',$dat);
        if (preg_match("/^lease/",$dat)){
                $ip = preg_split("/ /",$dat);
                $ip = $ip[1];
                if(!$ip){continue;}
                $leases[$ip]['ip'] = $ip;
                // print "HERE IT IS: ".$leases[$ip]['ip'];
                // print "<hr><b>lease:</b> "; print "<font color='blue'>".$ip."</font>";
                
        }elseif(preg_match("/starts/",$dat)){
                $starts = preg_split("/ /",$dat);
                $leases[$ip]['starts'] = $starts[2]." ".$starts[3];
                // print "<b>Starts:</b> "; print "<font color='blue'>".$starts[2]." ".$starts[3]."</font>";

        }elseif(preg_match("/ends/",$dat)){
                $ends = preg_split("/ /",$dat);
                $leases[$ip]['ends'] = $ends[2]." ".$ends[3];
                // print "<b>Ends:</b> ";print "<font color='blue'>".$ends[2]." ".$ends[3]."</font>";
                
        }elseif(preg_match("/tstp/",$dat)){
                $tstp = preg_split("/ /",$dat);
                $leases[$ip]['tstp'] = $tstp[2]." ".$tstp[3];
                // print "<b>tstp:</b> ";print "<font color='blue'>".$tstp[2]." ".$tstp[3]."</font>";

        }elseif(preg_match("/cltt/",$dat)){
                $cltt = preg_split("/ /",$dat);
                $leases[$ip]['cltt'] = $cltt[2]." ".$cltt[3];
                // print "<b>cltt:</b> ";print "<font color='blue'>".$cltt[2]." ".$cltt[3]."</font>";

        }elseif(preg_match("/^binding state/",$dat)){
                $bindingstate = preg_split("/ /",$dat);
                if(preg_replace('/\s/','',$bindingstate[2]) != 'active'){
                        //unset($leases[$ip]);
                        $leases[$ip]['bindingState'] = 'Active';
                       // $ip = NULL;
                        continue;
                }else{
                        $bindingState = preg_split("/ /",$dat);
                        $leases[$ip]['bindingState'] = 'Free';
                }

        }elseif(preg_match("/hardware ethernet/",$dat)){
                $hardwareethernet = preg_split("/ /",$dat);
                $leases[$ip]['hardwareethernet'] = $hardwareethernet[2];
                // print "<b>hardware ethernet:</b> ";print "<font color='blue'>".$hardwareethernet[2]."</font>";

        }elseif(preg_match("/uid/",$dat)){
                $uid = preg_replace('@\"@','',preg_split("/ /",$dat));
                $leases[$ip]['uid'] = htmlentities($uid[1]);
                //print "<b>uid:</b> ";print "<font color='blue'>".htmlentities($uid[1])."</font>";

        }elseif(preg_match("/client-hostname/",$dat)){
                $clientHostname = preg_replace('@\"@','',preg_split("/ /",$dat));
                $leases[$ip]['clientHostname'] = $clientHostname[1];
                //print "<b>client-hostname:</b> ";print "<font color='blue'>".$clientHostname[1]."</font>";

        }elseif(preg_match("/set vendor-class-identifier/",$dat)){
                $svci = preg_replace("/set\svendor-class\-identifier\s\=|\"/",'',$dat);
                $leases[$ip]['svci'] = $svci;
                //print "<b>set vendor-class-identifier:</b> ";print "<font color='blue'>".$svci."</font>";

        }elseif(preg_match("/\}$/",$dat)){
                $ip = NULL;
        }
}
sort($leases);
$newarray['status'] = 'success';
$newarray['data']['leases'] = $leases;
header('Content-Type: application/json; charset=utf-8');
$newerarray = json_encode($newarray);
print $newerarray;
?>
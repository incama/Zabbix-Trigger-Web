<div id="serverdata">
<div id="timestamp">
    <div id="date"><?php echo date("d F Y", time()); ?></div>
    <div id="time"><?php echo date("H:i:s", time()); ?></div>
    <div id="wat">Your Servers</div>
</div>
// Start the table ---------------------------------------------------------------------------------------------------------------------------------------
	<table style="width: 100%;">
		<tbody>
<?php
// load ZabbixApi
require 'lib/php/ZabbixApiAbstract.class.php';
require 'lib/php/ZabbixApi.class.php';
echo "<tr class=\"heading\"><th>Hostname</th><th style=\"width:400px;\">Description</th><th style=\"width:25px;\" >Priority</th><th style=\"width: 65px;\">Trigger ID</th><th style=\"width: 200px;\">Trigger Date</th><th style=\"width: 600px;\">Extra Info</th></tr>";
try {
    // connect to Zabbix API and set your refererences here ----------------------------------------------------------------------------------------------
    $api = new ZabbixApi('http://YOUR-ZABBIX-SERVER/zabbix/api_jsonrpc.php', 'USERNAME', 'PASSWORD');
    // Set Defaults --------------------------------------------------------------------------------------------------------------------------------------
    $api->setDefaultParams(array(
    		'selectHosts' => 'extend',
    ));
    // get hosts from groupid ----------------------------------------------------------------------------------------------------------------------------
    $events = $api->triggerGet(array(
		'output' => 'extend',
		'sortfield' => 'priority',
		'sortorder' => 'DESC',
		'groupids' => array('2','24','25','36','38','32'), // <-- PUT YOUR GROUPIDS HERE
		'only_true' => '1',
		'active' => '1',
		'withUnacknowledgedEvents' => '1'
));

// print all trigger IDs ---------------------------------------------------------------------------------------------------------------------------------
    foreach($events as $event) {
//	var_dump($event);
	$hostid = $event->hosts[0]->hostid;
	$hostname = $event->hosts[0]->name;
	$priority = $event->priority;
	$description = $event->description;
	$triggerid = $event->triggerid;
	$lastchange = $event->lastchange;
	$comments = $event->comments;
//	Strip the hostname macro name within certain trigger descriptions ------------------------------------------------------------------------------------
	$search = array('{HOSTNAME}', '{HOST.NAME}');
	$description = str_replace($search, "", $description);
	
//	Build the table --------------------------------------------------------------------------------------------------------------------------------------
	echo "<tr class=\"prio" . $priority . "\">";
	echo "<td>" . $hostname. "</td><td>" . $description .  "</td><td class=\"center\">" . $priority . "</td><td class=\"center\">" . $triggerid . "</td>";
	echo "<td>" . date('d-m-y H:i',$lastchange) . "</td>";
	echo "<td>" . $comments . "</td>";
	echo "</tr>";
    }
		} catch(Exception $e) {
//	Exception in ZabbixApi catched -----------------------------------------------------------------------------------------------------------------------
    echo $e->getMessage();
	}
?>
		</tbody>
	</table>
</div>

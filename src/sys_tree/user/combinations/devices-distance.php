<?php

/**
 * Calculates the great-circle distance between two points, with
 * the Haversine formula.
 * @param float $latitudeFrom Latitude of start point in [deg decimal]
 * @param float $longitudeFrom Longitude of start point in [deg decimal]
 * @param float $latitudeTo Latitude of target point in [deg decimal]
 * @param float $longitudeTo Longitude of target point in [deg decimal]
 * @param float $earthRadius Mean earth radius in [m]
 * @return float Distance between points in [m] (same as earthRadius)
 */
function haversineGreatCircleDistance(
  $latitudeFrom,
  $longitudeFrom,
  $latitudeTo,
  $longitudeTo,
  $earthRadius = 6371000
) {
  // convert from degrees to radians
  $latFrom = deg2rad($latitudeFrom);
  $lonFrom = deg2rad($longitudeFrom);
  $latTo = deg2rad($latitudeTo);
  $lonTo = deg2rad($longitudeTo);

  $lonDelta = $lonTo - $lonFrom;
  $a = pow(cos($latTo) * sin($lonDelta), 2) +
    pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
  $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

  $angle = atan2(sqrt($a), $b);
  return $angle * $earthRadius;
}

function calculateDistance($lat1, $lon1, $lat2, $lon2)
{
  $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins={$lat1},{$lon1}&destinations={$lat2},{$lon2}&key=AIzaSyBOU8P1s7w6vQMeTt2VKlFl8MQiLBxmOjI";
  $data = file_get_contents($url);
  $response = json_decode($data, true);
  $distance = $response['rows'][0]['elements'][0]['distance']['text'];
  $duration = $response['rows'][0]['elements'][0]['duration']['text'];

  return array('distance' => $distance, 'duration' => $duration);
}
// claculate distance between 2 coordinates in googlemap?

// check request method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // include Pieces class
  include_once '../../../../classes/global/Database.class.php';
  include_once '../../../../classes/sys_tree/Pieces.class.php';
  // create an object of Pieces class
  $pcs_obj = new Pieces();

  // get all devices
  $all_devices = $pcs_obj->get_all_pieces(base64_decode($_POST['company_id']), 0);
  $all_devices = $all_devices[0] == true && $all_devices[1] != null ? $all_devices[1] : null;
  // devices
  $devices = array();
  // check devices
  if ($all_devices != null) {
    // loop on devices to regenerate devices api
    foreach ($all_devices as $key => $device) {
      // check device coordinates
      if (count(explode(',', $device['coordinates'])) == 2) {
        $latLong = explode(',', $device['coordinates']);

        array_push($devices, array(
          'fullname' => $device['full_name'],
          'coordinates' => array(
            'lat' => $latLong[0],
            'lng' => $latLong[1],
          )
        ));
      }
    }

    echo json_encode($devices);
  } else {
    // return false
    echo json_encode(false);
  }
} else {
  // return false
  echo json_encode(false);
}

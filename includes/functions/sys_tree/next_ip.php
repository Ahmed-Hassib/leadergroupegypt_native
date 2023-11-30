<?php
function get_next_ip($ip)
{
  if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
    return long2ip(ip2long($ip) + 1);
  } else {
    return false; // invalid IP address
  }
}
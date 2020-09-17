<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    // Silahkan diisi dengan api_key dari rajaongkir.com
    "key: "
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  // Hasilnya dalam bentuk json
  // kita koversi ke array
  $array_response = json_decode($response, TRUE);
  $dataprovinsi = $array_response['rajaongkir']['results'];
  
  echo "<option value=''>-Pilih provinsi--</option>";

  foreach($dataprovinsi as $key => $tiap_provinsi){
    echo "<option value='".$tiap_provinsi['province_id']."' id_provinsi='".$tiap_provinsi['province_id']."'>";
    echo $tiap_provinsi['province'];
    echo "</option>";
  }
}
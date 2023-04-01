#include <WiFiNINA.h>
#include <IPAddress.h>
#include "secret.h"
#include "temperatura.h"
#include "umiditate.h"
#include "rtc.h"
#include <SD.h>

WiFiServer sv(80);
String readString;
String header;

void conectareWiFi(){
  WiFiClient client;

  const char* s = ssid;
  const char* p = password;

  Serial.begin(115200);
  Serial.print("Se conecteaza la ");
  Serial.print(s);

  WiFi.begin(s,p);

  while(WiFi.status() != WL_CONNECTED){
    delay(500);
    Serial.print(".");
  }

  Serial.println("");
  Serial.print("Conectat la ");
  Serial.println(s);
  Serial.print("Pentru a vedea pagina html de pe cardul sd mergi la: http://");
  Serial.println(WiFi.localIP());
  sv.begin();

}

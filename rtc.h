#include <WiFiNINA.h>
#include "ecran.h"

#include <NTPClient.h>
#include <WiFiUdp.h>

WiFiUDP ntpUDP;
//NTPClient timeClient(ntpUDP);
NTPClient timeClient(ntpUDP, "europe.pool.ntp.org", 10790, 60000);
//                           HH:MM:SS


void conectareNTP(){
  timeClient.begin();
}

  void afisareOra()
  {
    timeClient.update();
    Serial.print(timeClient.getHours());
    Serial.print(":");
    Serial.print(timeClient.getMinutes());
    Serial.print(":");
    Serial.print(timeClient.getSeconds());
    Serial.println();
  }

  void afisareOraEcran(){
    timeClient.update();
    tft.setCursor(270, 30);
    tft.fillRect(270,28,180,30,BLACK);

    tft.print(timeClient.getHours());
    tft.print(":");
    
    if (timeClient.getMinutes() < 10) {
      tft.print("0");
      tft.print(timeClient.getMinutes());
    }else{
      tft.print(timeClient.getMinutes());
    }
    tft.print(":");

    if (timeClient.getSeconds() < 10) {
      tft.print("0");
      tft.print(timeClient.getSeconds());
    }else{
      tft.print(timeClient.getSeconds());
    }

  }



  

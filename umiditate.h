#include <Adafruit_Sensor.h>
#include <DHT.h>
#include <DHT_U.h>

#define DHTPIN 12
#define DHTTYPE DHT11

//DHT_Unified dht(DHTPIN, DHTTYPE);

//uint32_t delayMS;

void initHumidity(){
  Serial.begin(9600);
  dht.begin();
  sensor_t sensor;
  dht.humidity().getSensor(&sensor);
  delayMS = sensor.min_delay / 1000;
}

float readhumidity(){
  delay(delayMS);
  sensors_event_t event;
  dht.humidity().getEvent(&event);
  if (isnan(event.relative_humidity)){
    Serial.println(F("Eroare la citirea umiditatii"));
  }
  else{
    Serial.print(F("Umiditatea: "));
    Serial.print(event.relative_humidity);
    Serial.println(F("%"));
    int humi = event.relative_humidity;
    return humi;
  }
}

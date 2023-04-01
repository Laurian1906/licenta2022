#include <Adafruit_Sensor.h>
#include <DHT.h>
#include <DHT_U.h>

#define DHTPIN 12
#define DHTTYPE DHT11
DHT_Unified dht(DHTPIN, DHTTYPE);

uint32_t delayMS;

void initTemp(){
  Serial.begin(9600);
  dht.begin();
  sensor_t sensor;
  dht.temperature().getSensor(&sensor);
  delayMS = sensor.min_delay / 1000;
}

float readTemp(){
  delay(delayMS);
  sensors_event_t event;
  dht.temperature().getEvent(&event);
  if (isnan(event.temperature)) {
    Serial.println(F("Error reading temperature!"));
  }
  else {
    Serial.print(F("Temperatura: "));
    Serial.print(event.temperature-2);
    Serial.println(F("°C"));
    float tempC = event.temperature-2;
    return tempC;
  }
}

//#include <OneWire.h>
//#include <DallasTemperature.h>
//
//#define ONE_WIRE_BUS A1
//OneWire oneWire(ONE_WIRE_BUS);
//DallasTemperature sensors (&oneWire);
//
//float readTemp(){
//  sensors.requestTemperatures();
//  float tempC = sensors.getTempCByIndex(0);
//  Serial.print("Temperatura: ");
//  Serial.println(tempC);
//  return tempC;
//}

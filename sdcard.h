#include <SD.h>
#include <SPI.h>

const int chipSelect = 11;
Sd2Card card;

void initializareCardSD(){
  SD.begin(chipSelect);
  Serial.print("\nInitializing SD card...");
  if (!SD.begin(chipSelect) && !card.init(SPI_HALF_SPEED, chipSelect)) {
    Serial.println("ESUAT!");
    while (1);
  }
  Serial.println("SUCCES!");
  if(SD.exists("index.htm")){
    Serial.println("S-a gasit fisierul index.htm");
  }
  else{
    Serial.println("Nu s-a gasit fisierul index.htm");
  }

}

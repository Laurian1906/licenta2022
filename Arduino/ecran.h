#include <SPI.h>
#include <Adafruit_GFX.h>
#include <Waveshare_ILI9486.h>

#define BLACK   0x0000
#define BLUE    0x001F
#define RED     0xF800
#define GREEN   0x07E0
#define CYAN    0x07FF
#define MAGENTA 0xF81F
#define YELLOW  0xFFE0
#define WHITE   0xFFFF

Waveshare_ILI9486 Waveshield;
Adafruit_GFX &tft = Waveshield;

void Screen(){
  SPI.begin();
  Waveshield.begin();

  // Initial setup
  tft.setRotation(1);
  tft.fillScreen(BLACK);
  
  // MonReg
  tft.setCursor(60,25);
  tft.setTextSize(4);
  tft.setTextColor(WHITE);
  tft.println("MonReg"); 
  tft.setCursor(240,25);
  tft.setTextSize(4);
  tft.setTextColor(WHITE);
  tft.println();

  tft.setTextSize(3.9);
  tft.setTextColor(CYAN);
  tft.setCursor(50,250);
  tft.print("http://");
  tft.println(WiFi.localIP());  
}

void setKeyboardW(){
  const char letters[26] = {'q','w','e','r','t','y','u','i','o','p','a','s','d','f','g','h',
  'j','k','l','z','x','c','v','b','n','m'};
  
  const char numbers[] = {'1', '2', '3', '4', '5', '6', '7', '8', '9', '0'};

  const char space = ' ';
  const char backspace = '<';

  // WiFi Title // 
  tft.setCursor(320, 32);
  tft.setTextColor(GREEN);
  tft.setTextSize(3.4);
  tft.print("WiFi");

  // SSID //
  tft.setCursor(68, 100);
  tft.setTextColor(WHITE);
  tft.setTextSize(3.2);
  tft.print("SSID: ");
  tft.fillRect(160, 97, 265, 30, BLUE);

  // PASSOWRD //
  tft.setCursor(68, 146);
  tft.setTextColor(WHITE);
  tft.setTextSize(3.2);
  tft.print("PASS: ");
  tft.fillRect(160, 143, 265, 30, BLUE);
  
  // KEYBOARD // 
  tft.setTextSize(3.8);
  tft.setTextColor(BLUE);
  for (int j=68; j<=126; j=j+100){
    tft.setCursor(j, 202);
    for (int i=0; i<26; i++){
      tft.print(letters[i]);
      tft.print(" ");
      if (i==9){    
        tft.setCursor(j+22, 235);
      }else if(i==18){ 
         tft.setCursor(j+46, 269);
      }
    }
  }
   
}

void TempScreen(){

  float tempC = readTemp();
  int umiditate = readhumidity();

  //tft.setCursor(320,25);

  delay(1000);
  tft.setTextSize(3.9);
  tft.setTextColor(WHITE);
  tft.setCursor(50,125);
  tft.print("Temperatura: ");
  tft.fillRect(282,121,90,30,BLACK);  //x,y,width,height,color
  tft.print(tempC);
  tft.print(" ");
  tft.print("\370");
  tft.println("C");
  tft.setTextColor(WHITE);
  tft.setCursor(50,165);
  tft.print("Umiditate: ");
  tft.fillRect(247,161,34,30,BLACK);
  tft.print(umiditate);
  tft.print("%"); 
  
}

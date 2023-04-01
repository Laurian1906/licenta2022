#include "wifi.h"
//#include "rtc.h"
//#include "ecran.h"
#include "sdcard.h"
#include "regulatorPI.h"

WiFiClient dbclient;
WiFiClient tclient;

const char* server = "monreg.atwebpages.com";  

void setup() {
  pinMode(LED, OUTPUT);
  //setp();
  conectareWiFi();
  conectareNTP();
  initializareCardSD();
  Screen();
  initHumidity();
  initTemp();
}

void loop() {
    loopReg();
//    bool out = loopReg();
//            
//    if (out == 0){
//      digitalWrite(LED, LOW);
//    }else if (out == 1){
//      digitalWrite(LED, HIGH);
//    }

  // --- PAGE --- // 

  WiFiClient client = sv.available();   // listen for incoming clients
  
  if (client) {  // if new client connects
    boolean currentLineIsBlank = true;
    while (client.connected()) {
      if (client.available()) {   // client data available to read
        char c = client.read(); // read 1 byte (character) from client
        header += c;
        
        // if the current line is blank, you got two newline characters in a row.
        // that's the end of the client HTTP request, so send a response:
        if (c == '\n' && currentLineIsBlank) {
          // send a standard http response header
          Serial.println(header);
          client.println("HTTP/1.1 200 OK");
          // Send XML file or Web page
          // If client already on the web page, browser requests with AJAX the latest
          // sensor readings (ESP32 sends the XML file)
          
          if (header.indexOf("update_readings") >= 0) {
//            // send rest of HTTP header
            client.println("Content-Type: text/xml");
            client.println("Connection: keep-alive");
            client.println();
//            // Send XML file with sensor readings
            client.print("<?xml version = \"1.0\" ?>");
            client.print("<inputs>");
            
            client.print("<reading>");
            client.print(readTemp());
            client.println("</reading>");
              
            client.print("</inputs>");
                       
          }else if(header.indexOf("tempVal") >= 0){
            String a = header.substring(13,15);
            Serial.println(a);
            Setpoint = a.toDouble();
            Serial.println(Setpoint);
          }
//          // When the client connects for the first time, send it the index.html file
//          // stored in the microSD card
          else {  
//            // send rest of HTTP header
            client.println("Content-Type: text/html");
            client.println("Connection: keep-alive");
            client.println();
//            // send web page stored in microSD card
            File webFile;
            webFile = SD.open("index.htm");

            if (webFile) {
              while(webFile.available()) {
                // send web page to client
                client.write(webFile.read()); 
              }
              webFile.close();
            }

          }
          
          break;
        }
        // every line of text received from the client ends with \r\n
        if (c == '\n') {
          // last character on line of received text
          // starting new line with next character read
          currentLineIsBlank = true;
        } 
        else if (c != '\r') {
          // a text character was received from client
          currentLineIsBlank = false;
        }
        } // end if (client.available())
    } // end while (client.connected())
    // Clear the header variable
    header = "";
    // Close the connection
    client.stop();
    Serial.println("Client disconnected.");
    
  } // end if (client)


  
if(dbclient.connect(server, 80)){
    Serial.println("Connected to database!");
    //Http request
    dbclient.print("GET /write_data.php?value=");
    dbclient.print(readTemp());
    dbclient.print("&humi=");
    dbclient.print(readhumidity());
    dbclient.println(" HTTP/1.1");
    dbclient.println("Host: monreg.atwebpages.com");
    dbclient.println("X-Auth-Token: 23q4fg98herw8vuhq8rvjhnbq3jnrgfq03u4hrnvjuiqdenv8721812e91283e1092diqjcnvjaewnvoiqa");
    dbclient.println("Connection: close");
    dbclient.println();
    dbclient.println();
    dbclient.stop();
    //delay(15000);
}else{
  Serial.println("Connection failed \n");
}

  readhumidity();
  readTemp();
  //setKeyboardW();
  TempScreen();
  afisareOraEcran();
  afisareOra();



}

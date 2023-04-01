#define LED 5

double Setpoint, Input;

bool loopReg()
{
  Input = readTemp();
  Serial.print("Intrarea: ");
  Serial.println(Input); 

  bool digitalOutput;
  
  if (Input >= Setpoint){
    digitalWrite(LED, LOW);
    Serial.println("LED IS OFF");
  }else if (Input < Setpoint){
    digitalWrite(LED, HIGH);
    Serial.println("LED IS ON");
  }


}

package com.example;

public class Gato extends Mascotas {

    private String color;
    private boolean peloLargo;

    public Gato(String nombre, int edad, boolean estado, String fechaNacimiento, String color, boolean peloLargo) {

        super(nombre, edad, estado, fechaNacimiento);
        this.color = color;
        this.peloLargo = peloLargo;

    }

    public String getColor() {
        return color;
    }

    public void setColor(String color) {
        this.color = color;
    }

    public boolean isPeloLargo() {
        return peloLargo;
    }

    public void setPeloLargo(boolean peloLargo) {
        this.peloLargo = peloLargo;
    }

    //------------------------------------------------------------------------------------------

    public void muestra(){

        System.out.println("Gato: " + getNombre());
        System.out.println("Edad: " + getEdad());
        System.out.println("Color: " + getColor());
        
        if(peloLargo){
            System.out.println("Es de pelo largo");
        }else{
            System.out.println("No es de pelo largo");
        }

    }

    public void habla(){
        System.out.println("Gato: ''MIAU''");
    }

    public void primeralinea(){
        System.out.println("Gato: " + getNombre());
    }
    

}

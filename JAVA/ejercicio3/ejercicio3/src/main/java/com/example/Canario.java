package com.example;

public class Canario extends Aves {

    private String color;
    private String canta;

    public Canario(String nombre, int edad, boolean estado, String fechaNacimiento, String pico, boolean vuela, String color, String canta) {

        super(nombre, edad, estado, fechaNacimiento, pico, vuela);
        this.color = color;
        this.canta = canta;

    }

    public String getColor() {
        return color;
    }

    public void setColor(String color) {
        this.color = color;
    }

    public String getCanta() {
        return canta;
    }

    public void setCanta(String canta) {
        this.canta = canta;
    }

    //-------------------------------------------------------------------------------

    public void muestra(){

        System.out.println("Canario: " + getNombre());
        System.out.println("Edad: " + getEdad());
        System.out.println("Pico: " + getPico());
        System.out.println("Color: " + getColor());

    }

    public void habla(){
        System.out.println(canta);
    }

    public void volar(){

        if(getVuela()){
            System.out.println("¡Sí! Los canarios son pájaros y, como tales, tienen la capacidad de volar. Son conocidos por su capacidad para volar cortas distancias");
        }else{
            System.out.println("No vuela");
        }

    }
    
    public void primeralinea(){
        System.out.println("Canario: " + getNombre());
    }


    
}

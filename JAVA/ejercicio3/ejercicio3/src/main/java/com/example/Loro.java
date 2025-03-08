package com.example;

public class Loro extends Aves {

    private String origen;
    private String habla;

    public Loro(String nombre, int edad, boolean estado, String fechaNacimiento, String pico, boolean vuela, String origen, String habla) {

        super(nombre, edad, estado, fechaNacimiento, pico, vuela);
        this.origen = origen;
        this.habla = habla;

    }

    public String getOrigen() {
        return origen;
    }

    public void setOrigen(String origen) {
        this.origen = origen;
    }

    public String getHabla() {
        return habla;
    }

    public void setHabla(String habla) {
        this.habla = habla;
    }

    //---------------------------------------------------------------------------------

    public void muestra(){

        System.out.println("Loro: " + getNombre());
        System.out.println("Edad: " + getEdad());
        System.out.println("Pico: " + getPico());
        System.out.println("Origen: " + getOrigen());

    }

    public void saluda(){
        System.out.println(habla);
    }

    public void volar(){

        if(getVuela()){
            System.out.println("¡Sí, los loros pueden volar! Son aves muy habilidosas en el vuelo y tienen la capacidad de volar distancias considerablemente largas en su hábitat natural");
        }else{
            System.out.println("No vuela");
        }

    }

    public void primeralinea(){
        System.out.println("Loro: " + getNombre());
    }

    

}

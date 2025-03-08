package com.example;

public class Perro extends Mascotas {

    private String raza;
    private boolean pulgas;

    public Perro(String nombre, int edad, boolean estado, String fechaNacimiento, String raza, boolean pulgas) {

        super(nombre, edad, estado, fechaNacimiento);
        this.raza = raza;
        this.pulgas = pulgas;

    }

    public String getRaza() {
        return raza;
    }

    public void setRaza(String raza) {
        this.raza = raza;
    }

    public boolean isPulgas() {
        return pulgas;
    }

    public void setPulgas(boolean pulgas) {
        this.pulgas = pulgas;
    }

    //-------------------------------------------------------------------------------------------------

    public void muestra(){

        System.out.println("Perro: " + getNombre());
        System.out.println("Edad: " + getEdad());
        System.out.println("Raza: " + raza);
        
        if(pulgas){
            System.out.println("Tiene pulgas");
        }else{
            System.out.println("No tiene pulgas");
        }

    }

    public void habla(){
        System.out.println("Perro: ''GUAU''");
    }

    public void primeralinea(){
        System.out.println("Perro: " + getNombre());
    }
    

}

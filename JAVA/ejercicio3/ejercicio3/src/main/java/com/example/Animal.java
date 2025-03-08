package com.example;

public class Animal extends Mascotas {

    private String especie;

    public Animal(String nombre, int edad, boolean estado, String fechaNacimiento, String especie) {

        super(nombre, edad, estado, fechaNacimiento);
        this.especie = especie;

    }


    public void muestra(){

        System.out.println(especie + ": " + getNombre());
        System.out.println("Edad: " + getEdad());
        System.out.println("Fecha de nacimiento: " + getFechaNacimiento());
        
        if(getEstado()){
            System.out.println("Está vivo");
        }else{
            System.out.println("Está muerto");
        }

    }

    public void primeralinea(){
        System.out.println(especie + ": " + getNombre());
    }



    public String getEspecie() {
        return especie;
    }



    public void setEspecie(String especie) {
        this.especie = especie;
    }




    
}

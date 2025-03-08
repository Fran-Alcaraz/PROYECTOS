package com.example;

public abstract class Mascotas {

    private String nombre;
    private int edad;
    private boolean estado;
    private String fechaNacimiento;

    public Mascotas(String nombre, int edad, boolean estado, String fechaNacimiento) {

        this.nombre = nombre;
        this.edad = edad;
        this.estado = estado;
        this.fechaNacimiento = fechaNacimiento;

    }

    public String getNombre() {
        return nombre;
    }

    public void setNombre(String nombre) {
        this.nombre = nombre;
    }

    public int getEdad() {
        return edad;
    }

    public void setEdad(int edad) {
        this.edad = edad;
    }

    public boolean getEstado() {
        return estado;
    }

    public void setEstado(boolean estado) {
        this.estado = estado;
    }

    public String getFechaNacimiento() {
        return fechaNacimiento;
    }

    public void setFechaNacimiento(String fechaNacimiento) {
        this.fechaNacimiento = fechaNacimiento;
    }

    //-------------------------------------------------------------------

    public void muestra(){
        
    }

    public String cumpleaños(){

        return "nació el " + fechaNacimiento;

    }

    public String morir(){

        if(estado){
            return "está vivo";
        }else{
            return "está muerto";
        }

    }

    public void habla(){

    }

    public void primeralinea(){

    }
   


}
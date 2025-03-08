package com.example;

import java.util.*;

public class Inventario {

    public static void main(String[] args) {

        Scanner entrada = new Scanner(System.in);

        ArrayList<Mascotas> animales = new ArrayList<>();

        int opcion = 0;
        int numeroAnimal;

        Mascotas animalSeleccionado;

        String nombre;
        int edad;
        String estado;
        String fechaNacimiento;
        boolean estadoBoolean;
        String especie;

        String habla = "Loro: ''Hola Paco''";
        String canta = "Canario: ''Pipiripi''";

        Perro perro = new Perro("Nala", 1, true, "06-02-2023", "Labrador", false);
        Gato gato = new Gato("Júpiter", 5, true, "03-08-2019", "Negro y blanco", false);
        Loro loro = new Loro("Perico", 7, true, "27-11-2017", "Grande", true, "Islas Canarias", habla);
        Canario canario = new Canario("Josua", 8, false, "15-10-2016", "Pequeño", true, "Azul", canta);

        animales.add(perro);
        animales.add(gato);
        animales.add(loro);
        animales.add(canario);

        


        while(opcion != 8){

        System.out.println("");
        System.out.println("-------------------------------------------");
        System.out.println("MENÚ");
        System.out.println("1. Mostrar la lista de animales");
        System.out.println("2. Mostrar los datos de un animal");
        System.out.println("3. Mostrar los datos de todos los animales");
        System.out.println("4. Insertar un animal");
        System.out.println("5. Eliminar un animal");
        System.out.println("6. Mostrar datos adicionales");
        System.out.println("7. Eliminar todo el inventario");
        System.out.println("8. Salir");
        opcion = entrada.nextInt();
        entrada.nextLine();

        switch (opcion) {
            case 1:                                                                                                                                 System.out.println("");
            
                for(int i = 0; i < animales.size(); i++){

                    Mascotas mascota = animales.get(i);
        
                    System.out.print((i + 1) + ". ");
                    mascota.primeralinea();
        
                }

                break;


            case 2:                                                                                                                                 System.out.println("");
                
                System.out.println("Elige el número del animal que quieres mostrar:");
                numeroAnimal = entrada.nextInt();
                entrada.nextLine();

                animalSeleccionado = animales.get(numeroAnimal - 1);
                animalSeleccionado.muestra();

                break;


            case 3:                                                                                                                                 System.out.println("");

            for(int i = 0; i < animales.size(); i++){

                Mascotas mascota = animales.get(i);
    
                mascota.muestra();
                System.out.println();
    
            }

                break;


            case 4:                                                                                                                                 System.out.println("");
                
                System.out.print("Ingrese la especie del animal: ");
                especie = entrada.nextLine();

                System.out.print("Ingrese el nombre del animal: ");
                nombre = entrada.nextLine();

                System.out.print("Ingrese la edad del animal: ");
                edad = entrada.nextInt();
                entrada.nextLine();

                System.out.print("Ingrese el estado del animal (Vivo o Muerto): ");
                estado = entrada.nextLine();

                System.out.print("Ingrese la fecha de nacimiento del animal: ");
                fechaNacimiento = entrada.nextLine();

                if(estado.equalsIgnoreCase("Muerto")){
                    estadoBoolean = false;
                }else{
                    estadoBoolean = true;
                }

                Animal animal = new Animal(nombre, edad, estadoBoolean, fechaNacimiento, especie);
                animales.add(animal);

                System.out.println("¡El animal ha sido agregado correctamente!");

                break;


            case 5:                                                                                                                                 System.out.println("");
                    
                System.out.println("Elige el número del animal que quieres eliminar:");
                numeroAnimal = entrada.nextInt();
                entrada.nextLine();

                animales.remove(numeroAnimal - 1);

                System.out.println("¡El animal ha sido eliminado correctamente!");

                break;


            case 6:                                                                                                                                 System.out.println("");

                System.out.println("La perra " + perro.getNombre() + " " + perro.cumpleaños());
                System.out.println("El canario " + canario.getNombre() + " " + canario.morir());
                System.out.println("");
        
                perro.habla();
        
                System.out.println("");
        
                gato.habla();
        
                System.out.println("");
        
                loro.saluda();
                loro.volar();
                
                System.out.println("");
        
                canario.habla();
                canario.volar();

                break;


            case 7:                                                                                                                                 System.out.println("");
                
                animales.clear();

                break;


            case 8:                                                                                                                                 System.out.println("");
                
                break;
        

            default:                                                                                                                                System.out.println("");
                System.err.println("La opción seleccionada no es válida.");
                break;
        }

        }

        System.out.println("Programa terminado.");



        
        

        


    }

}

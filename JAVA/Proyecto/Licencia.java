import javax.swing.*;
import javax.swing.event.*;
import java.awt.*;
import java.awt.event.*;


public class Licencia extends JFrame implements ActionListener, ChangeListener{

 private JLabel label1, label2;
 private JCheckBox checkbox;
 private JButton boton1, boton2;
 private JScrollPane scrollpane;
 private JTextArea textarea;
 String nombre = "";


public Licencia(){

 setLayout(null);
 setDefaultCloseOperation(EXIT_ON_CLOSE);
 setTitle("Licencia de uso");
 setIconImage(new ImageIcon(getClass().getResource("images/icon.png")).getImage());
 Bienvenida interfazbienvenida = new Bienvenida();
 nombre = interfazbienvenida.texto;

 label1 = new JLabel("TÉRMINOS Y CONDICIONES");
 label1.setBounds(215,5,200,30);
 label1.setFont(new Font("Andale Mono", 1, 14));
 label1.setForeground(new Color(0,0,0));
 add(label1);

 textarea = new JTextArea();
 textarea.setEditable(false);
 textarea.setFont(new Font("Andale Mono",0,9));
 textarea.setText("\n\n          TÉRMINOS Y CONDICIONES" +
                  "\n\n            A.  PROHIBIDA SU VENTA O DISTRIBUCIÓN SIN AUTORIZACIÓN DE FRANKI." +
                  "\n            B.  PROHIBIDA LA ALTERACIÓN DEL CÓDIGO FUENTE O DISEÑO DE LAS INTERFACES GRÁFICAS." +
                  "\n            C.  FRANKI NO SE HACE RESPONSABLE DEL MAL USO DE ESTE SOFTWARE." +
                  "\n\n          LOS ACUERDOS LEGALES EXPUESTOS A CONTINUACIÓN RIGEN EL USO QUE USTED HAGA DE ESTE SOFTWARE" +
                  "\n          (FRANKI), NO SE RESPONSABILIZAN DEL USO QUE USTED" + 
                  "\n          HAGA CON ESTE SOFTWARE Y SUS SERVICIOS. PARA ACEPTAR ESTOS TERMINOS HAGA CLIC EN (ACEPTO)" +
                  "\n          SI USTED NO ACEPTA ESTOS TERMINOS, HAGA CLIC EN (NO ACEPTO) Y NO UTILICE ESTE SOFTWARE." + 
                  "\n\n          PARA MAYOR INFORMACIÓN SOBRE NUESTROS PRODUCTOS O SERVICIOS, POR FAVOR VISITE" + 
                  "\n          http://www.youtube.com/franki33");

 scrollpane = new JScrollPane(textarea);
 scrollpane.setBounds(10,40,575,200);
 add(scrollpane);

 checkbox = new JCheckBox("Yo, " + nombre + ", acepto");
 checkbox.setBounds(10,250,300,30);
 checkbox.addChangeListener(this);
 add(checkbox);

 boton1 = new JButton("Continuar");
 boton1.setBounds(10,290,100,30);
 boton1.addActionListener(this);
 boton1.setEnabled(false);
 add(boton1);

 boton2 = new JButton("No acepto");
 boton2.setBounds(120,290,100,30);
 boton2.addActionListener(this);
 boton2.setEnabled(true);
 add(boton2);

 ImageIcon imagen = new ImageIcon("images/coca-cola.png");
 label2 = new JLabel(imagen);
 label2.setBounds(315,135,300,300);
 add(label2);
}



public void stateChanged(ChangeEvent e){

 if(checkbox.isSelected() == true){
    boton1.setEnabled(true);
    boton2.setEnabled(false);
 } else {
    boton1.setEnabled(false);
    boton2.setEnabled(true);
   }
}



public void actionPerformed(ActionEvent e){

 if(e.getSource() == boton1){
     Principal interfazPrincipal = new Principal();
     interfazPrincipal.setBounds(0,0,640,535);
     interfazPrincipal.setVisible(true);
     interfazPrincipal.setResizable(false);
     interfazPrincipal.setLocationRelativeTo(null);
     this.setVisible(false);
 }

 if(e.getSource() == boton2){
     Bienvenida interfazbienvenida = new Bienvenida();
     interfazbienvenida.setBounds(0,0,350,450);
     interfazbienvenida.setVisible(true);
     interfazbienvenida.setResizable(false);
     interfazbienvenida.setLocationRelativeTo(null);
     this.setVisible(false);
 }
}



public static void main(String args[]){

 Licencia interfazlicencia = new Licencia();
 interfazlicencia.setBounds(0,0,610,370);
 interfazlicencia.setVisible(true);
 interfazlicencia.setResizable(false);
 interfazlicencia.setLocationRelativeTo(null);
}
}
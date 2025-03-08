import javax.swing.*;
import java.awt.*;
import java.awt.event.*;



public class Principal extends JFrame implements ActionListener{

 private JMenuBar menuBar;
 private JMenu menuOpciones, menuCalcular, menuAcercaDe, menuFondo;
 private JMenuItem miCalculo, miRojo, miNegro, miMorado, miCreador, miSalir, miNuevo;
 private JLabel labelLogo, labelBienvenido, labelTitle, labelNombre, labelAPaterno, labelAMaterno,
                labelDepartamento, labelAntiguedad, labelResultado, labelFooter;
 private JTextField tfNombreTrabajador, tfAPaterno, tfAMaterno;
 private JComboBox cbDepartamento, cbAntiguedad;
 private JTextArea textarea;
 private JScrollPane scrollpane;
 String nombre = "";
 


public Principal(){

 setLayout(null);
 setDefaultCloseOperation(EXIT_ON_CLOSE);
 setTitle("Pantalla principal");
 getContentPane().setBackground(new Color(255,0,0));
 setIconImage(new ImageIcon(getClass().getResource("images/icon.png")).getImage());
 Bienvenida interfazbienvenida = new Bienvenida();
 nombre = interfazbienvenida.texto;
 
 menuBar = new JMenuBar();
 menuBar.setBackground(new Color(255,0,0));
 setJMenuBar(menuBar);

 menuOpciones = new JMenu("Opciones");
 menuOpciones.setBackground(new Color(255,0,0));
 menuOpciones.setForeground(new Color(255,255,255));
 menuOpciones.setFont(new Font("Andale Mono",1,14));
 menuBar.add(menuOpciones);

 menuCalcular = new JMenu("Calcular");
 menuCalcular.setBackground(new Color(255,0,0));
 menuCalcular.setForeground(new Color(255,255,255));
 menuCalcular.setFont(new Font("Andale Mono",1,14));
 menuBar.add(menuCalcular);

 menuAcercaDe = new JMenu("Acerca de");
 menuAcercaDe.setBackground(new Color(255,0,0));
 menuAcercaDe.setForeground(new Color(255,255,255));
 menuAcercaDe.setFont(new Font("Andale Mono",1,14));
 menuBar.add(menuAcercaDe);

 menuFondo = new JMenu("Color de fondo");
 menuFondo.setFont(new Font("Andale Mono",1,14));
 menuFondo.setForeground(new Color(255,0,0));
 menuOpciones.add(menuFondo);

 miCalculo = new JMenuItem("Vacaciones");
 miCalculo.setFont(new Font("Andale Mono",1,14));
 miCalculo.setForeground(new Color(255,0,0));
 miCalculo.addActionListener(this);
 menuCalcular.add(miCalculo);

 miRojo = new JMenuItem("Rojo");
 miRojo.setForeground(new Color(255,0,0));
 miRojo.setFont(new Font("Andale Mono",1,14));
 miRojo.addActionListener(this);
 menuFondo.add(miRojo);

 miNegro = new JMenuItem("Negro");
 miNegro.setForeground(new Color(255,0,0));
 miNegro.setFont(new Font("Andale Mono",1,14));
 miNegro.addActionListener(this);
 menuFondo.add(miNegro);

 miMorado = new JMenuItem("Morado");
 miMorado.setForeground(new Color(255,0,0));
 miMorado.setFont(new Font("Andale Mono",1,14));
 miMorado.addActionListener(this);
 menuFondo.add(miMorado);

 miCreador = new JMenuItem("El creador");
 miCreador.setFont(new Font("Andale Mono",1,14));
 miCreador.setForeground(new Color(255,0,0));
 miCreador.addActionListener(this);
 menuAcercaDe.add(miCreador);

 miSalir = new JMenuItem("Salir");
 miSalir.setFont(new Font("Andale Mono",1,14));
 miSalir.setForeground(new Color(255,0,0));
 miSalir.addActionListener(this);
 menuOpciones.add(miSalir);

 miNuevo = new JMenuItem("Nuevo");
 miNuevo.setFont(new Font("Andale Mono",1,14));
 miNuevo.setForeground(new Color(255,0,0));
 miNuevo.addActionListener(this);
 menuOpciones.add(miNuevo);
 
 ImageIcon imagen = new ImageIcon("images/logo-coca.png");
 labelLogo = new JLabel(imagen);
 labelLogo.setBounds(5,5,250,100);
 add(labelLogo);

 labelBienvenido = new JLabel("Bienvenido " + nombre);
 labelBienvenido.setBounds(280,30,300,50);
 labelBienvenido.setFont(new Font("Andale Mono",1,32));
 labelBienvenido.setForeground(new Color(255,255,255));
 add(labelBienvenido);

 labelTitle = new JLabel("Datos del trabajador para el cálculo de vacaciones");
 labelTitle.setBounds(45,140,900,25);
 labelTitle.setFont(new Font("Andale Mono",0,24));
 labelTitle.setForeground(new Color(255,255,255));
 add(labelTitle);

 labelNombre = new JLabel("Nombre completo:");
 labelNombre.setBounds(25,188,180,25);
 labelNombre.setFont(new Font("Andale Mono",1,12));
 labelNombre.setForeground(new Color(255,255,255));
 add(labelNombre);

 labelAPaterno = new JLabel("Primer apellido:");
 labelAPaterno.setBounds(25,248,180,25);
 labelAPaterno.setFont(new Font("Andale Mono",1,12));
 labelAPaterno.setForeground(new Color(255,255,255));
 add(labelAPaterno);

 labelAMaterno = new JLabel("Segundo apellido:");
 labelAMaterno.setBounds(25,308,180,25);
 labelAMaterno.setFont(new Font("Andale Mono",1,12));
 labelAMaterno.setForeground(new Color(255,255,255));
 add(labelAMaterno);

 labelDepartamento = new JLabel("Selecciona el Departamento:");
 labelDepartamento.setBounds(220,188,180,25);
 labelDepartamento.setFont(new Font("Andale Mono",1,12));
 labelDepartamento.setForeground(new Color(255,255,255));
 add(labelDepartamento);

 labelAntiguedad = new JLabel("Selecciona la Antigüedad:");
 labelAntiguedad.setBounds(220,248,180,25);
 labelAntiguedad.setFont(new Font("Andale Mono",1,12));
 labelAntiguedad.setForeground(new Color(255,255,255));
 add(labelAntiguedad);

 labelResultado = new JLabel("Resultado del Cálculo:");
 labelResultado.setBounds(220,307,180,25);
 labelResultado.setFont(new Font("Andale Mono",1,12));
 labelResultado.setForeground(new Color(255,255,255));
 add(labelResultado);

 labelFooter = new JLabel("©2023 The Coca-Cola Company | Todos los derechos reservados");
 labelFooter.setBounds(135,445,500,30);
 labelFooter.setFont(new Font("Andale Mono",1,12));
 labelFooter.setForeground(new Color(255,255,255));
 add(labelFooter);

 tfNombreTrabajador = new JTextField();
 tfNombreTrabajador.setBounds(25,213,150,25);
 tfNombreTrabajador.setBackground(new Color(224,224,224));
 tfNombreTrabajador.setFont(new Font("Andale Mono",1,14));
 tfNombreTrabajador.setForeground(new Color(255,0,0));
 add(tfNombreTrabajador);

 tfAPaterno = new JTextField();
 tfAPaterno.setBounds(25,273,150,25);
 tfAPaterno.setBackground(new Color(224,224,224));
 tfAPaterno.setFont(new Font("Andale Mono",1,14));
 tfAPaterno.setForeground(new Color(255,0,0));
 add(tfAPaterno);

 tfAMaterno = new JTextField();
 tfAMaterno.setBounds(25,334,150,25);
 tfAMaterno.setBackground(new Color(224,224,224));
 tfAMaterno.setFont(new Font("Andale Mono",1,14));
 tfAMaterno.setForeground(new Color(255,0,0));
 add(tfAMaterno);

 cbDepartamento = new JComboBox();
 cbDepartamento.setBounds(220,213,220,25);
 cbDepartamento.setBackground(new Color(224,224,224));
 cbDepartamento.setFont(new Font("Andale Mono",1,14));
 cbDepartamento.setForeground(new Color(255,0,0));
 add(cbDepartamento);
 cbDepartamento.addItem("");
 cbDepartamento.addItem("Atención al Cliente");
 cbDepartamento.addItem("Departamento de Logística");
 cbDepartamento.addItem("Departamento de Gerencia");

 cbAntiguedad = new JComboBox();
 cbAntiguedad.setBounds(220,273,220,25);
 cbAntiguedad.setBackground(new Color(224,224,224));
 cbAntiguedad.setFont(new Font("Andale Mono",1,14));
 cbAntiguedad.setForeground(new Color(255,0,0));
 add(cbAntiguedad);
 cbAntiguedad.addItem("");
 cbAntiguedad.addItem("1 año de servicio");
 cbAntiguedad.addItem("2 a 6 años de servicio");
 cbAntiguedad.addItem("7 años o más de servicio");

 textarea = new JTextArea();
 textarea.setEditable(false);
 textarea.setBackground(new Color(224,224,224));
 textarea.setFont(new Font("Andale Mono",1,11));
 textarea.setForeground(new Color(255,0,0));
 textarea.setText("\n   Aquí aparece el resultado del cálculo de las vacaciones.");
 scrollpane = new JScrollPane(textarea);
 scrollpane.setBounds(220,333,385,90);
 add(scrollpane);
}



public void actionPerformed(ActionEvent e){

 if(e.getSource() == miCalculo){
  
  String nombreTrabajador = tfNombreTrabajador.getText();
  String AP = tfAPaterno.getText();
  String AM = tfAMaterno.getText();
  String Departamento = cbDepartamento.getSelectedItem().toString();
  String Antiguedad = cbAntiguedad.getSelectedItem().toString();

  if(nombreTrabajador.equals("") || AP.equals("") || AM.equals("") || Departamento.equals("") || Antiguedad.equals("")){

   JOptionPane.showMessageDialog(null, "Debes de rellenar todos los campos.");

  } else{
    
     if(Departamento.equals("Atención al Cliente")){

         if(Antiguedad.equals("1 año de servicio")){
          textarea.setText("\n El trabajador " + nombreTrabajador + " " + AP + " " + AM +
			   ",\n quien trabaja en " + Departamento + ", con " + Antiguedad +
			   ",\n recibe 6 días de vacaciones.");
         }

         if(Antiguedad.equals("2 a 6 años de servicio")){
	  textarea.setText("\n El trabajador " + nombreTrabajador + " " + AP + " " + AM +
			   ",\n quien trabaja en " + Departamento + ", con " + Antiguedad +
			   ",\n recibe 14 días de vacaciones.");
         }

         if(Antiguedad.equals("7 años o más de servicio")){
	  textarea.setText("\n El trabajador " + nombreTrabajador + " " + AP + " " + AM +
			   ",\n quien trabaja en " + Departamento + ", con " + Antiguedad +
			   ",\n recibe 20 días de vacaciones.");
         }
     }



    if(Departamento.equals("Departamento de Logística")){

 	if(Antiguedad.equals("1 año de servicio")){
          textarea.setText("\n El trabajador " + nombreTrabajador + " " + AP + " " + AM +
			   ",\n quien trabaja en " + Departamento + ", con " + Antiguedad +
			   ",\n recibe 7 días de vacaciones.");
         }

         if(Antiguedad.equals("2 a 6 años de servicio")){
	  textarea.setText("\n El trabajador " + nombreTrabajador + " " + AP + " " + AM +
			   ",\n quien trabaja en " + Departamento + ", con " + Antiguedad +
			   ",\n recibe 15 días de vacaciones.");
         }

         if(Antiguedad.equals("7 años o más de servicio")){
	  textarea.setText("\n El trabajador " + nombreTrabajador + " " + AP + " " + AM +
			   ",\n quien trabaja en " + Departamento + ", con " + Antiguedad +
			   ",\n recibe 22 días de vacaciones.");
         }
    }



    if(Departamento.equals("Departamento de Gerencia")){

 	if(Antiguedad.equals("1 año de servicio")){
          textarea.setText("\n El trabajador " + nombreTrabajador + " " + AP + " " + AM +
			   ",\n quien trabaja en " + Departamento + ", con " + Antiguedad +
			   ",\n recibe 10 días de vacaciones.");
         }

         if(Antiguedad.equals("2 a 6 años de servicio")){
	  textarea.setText("\n El trabajador " + nombreTrabajador + " " + AP + " " + AM +
			   ",\n quien trabaja en " + Departamento + ", con " + Antiguedad +
			   ",\n recibe 20 días de vacaciones.");
         }

         if(Antiguedad.equals("7 años o más de servicio")){
	  textarea.setText("\n El trabajador " + nombreTrabajador + " " + AP + " " + AM +
			   ",\n quien trabaja en " + Departamento + ", con " + Antiguedad +
			   ",\n recibe 30 días de vacaciones.");
         }
    }

    }

 }




 if(e.getSource() == miRojo){
  getContentPane().setBackground(new Color(255,0,0));
 }

 if(e.getSource() == miNegro){
  getContentPane().setBackground(new Color(0,0,0));
 }

 if(e.getSource() == miMorado){
  getContentPane().setBackground(new Color(51,0,51));
 }


 if(e.getSource() == miNuevo){
  
  tfNombreTrabajador.setText("");
  tfAPaterno.setText("");
  tfAMaterno.setText("");
  cbDepartamento.setSelectedIndex(0);
  cbAntiguedad.setSelectedIndex(0);
  textarea.setText("\n   Aquí aparece el resultado del cálculo de las vacaciones.");
 }


 if(e.getSource() == miSalir){

  Bienvenida interfazbienvenida = new Bienvenida();
  interfazbienvenida.setBounds(0,0,350,450);
  interfazbienvenida.setVisible(true);
  interfazbienvenida.setResizable(false);
  interfazbienvenida.setLocationRelativeTo(null);
  this.setVisible(false);
 }


 if(e.getSource() == miCreador){
  
  JOptionPane.showMessageDialog(null, "Desarrollado por Franki \n" +
				      "www.twitch.tv/franki33_");
 }

}



public static void main(String args[]){

 Principal interfazPrincipal = new Principal();
 interfazPrincipal.setBounds(0,0,640,535);
 interfazPrincipal.setVisible(true);
 interfazPrincipal.setResizable(false);
 interfazPrincipal.setLocationRelativeTo(null);
}

}
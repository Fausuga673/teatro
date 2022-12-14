<?php

/* 馃

Nombre: Frey Alexander Usuga Carre帽o 
Programa: Fundamentos de programaci贸n
Taller: Uso de formularios para transferencia

*/

# Obtenemos la informaci贸n de database.txt,
# guardamos la informaci贸n en un array,
# cada elemento estar谩 separado por cada salto de l铆nea.   
$database = explode("\n", file_get_contents('admin/database.txt'));

# Nuevamente obtenemos la informaci贸n de database.txt, solo que en "forma de cadena"
$contenido = file_get_contents("admin/database.txt");

$alerta = 0;

# Si hay envio de informaci贸n
if ($_POST) {
    
    # Si el bot贸n de 'enviar' es accionado
    if (isset($_POST['enviar'])) {
    
        # Verificamos si se marc贸 una opci贸n
        if (isset($_POST['opcion'])) {
    
            $i = 0;
            $a = 0;
            $numeroPuestos = 25;
        
            $fila = $_POST['fila'];
            $puesto = $_POST['puesto'];
            $opcion= $_POST['opcion'];
            
            # el contenido de database.txt pasar谩 a ser un array asociativo.
            while ($i != $numeroPuestos) {
        
                $i++;                                                                       # $i incrementa su valor dependiendo de las veces que se ejecute el ciclo.
                $valor = $database[$i-1][-1];                                               # recorremos la informaci贸n de $database y la guardamos como valor.
                $llave = substr($database[$i-1], 0, -2);                                    # esto devuelve por ejemplo "1 : 1" ("fila : puesto"), lo cual usaremos como llave.
        
                $newDB["$llave"] = "$valor";                                                # finalmente transformamos el contenido de database.txt en un array asociativo.
                
            }
        
            while ($a != $numeroPuestos) {
        
                $a++;                                                                       # $a incrementa su valor dependiendo de las veces que se ejecute el ciclo
                $puestoBusqueda = "$fila : $puesto ".$database[$a-1][-1];                   # recorremos la informaci贸n de $database hasta que sea igual a la fila y puesto que buscamos
                $peticion = "$fila : $puesto $opcion";                                      # guardamos el puesto que se desea alterar y la opci贸n que el usuario desea
        
                # si el usuario ingresa un puesto v谩lido
                if (isset($newDB["$fila : $puesto"])) {
                
                    # si el valor de la llave es diferente de V (vendido)
                    if ($newDB["$fila : $puesto"] !== "V") {
        
                        $alerta = 1;
                        $contenido = str_replace($puestoBusqueda, $peticion, $contenido);   # modificamos la informaci贸n de acuerdo a lo que se haya solicitado
                        file_put_contents("admin/database.txt", $contenido);                # confirmamos la modificaci贸n
                        
                        # recargamos la p谩gina
                        ?><script>
                        setTimeout(function () {                                            
                                window.location.href = 'index.php';
                            }, 1500);
                        </script><?php

                    } else {
                        
                        ?><script>swal("Ese puesto ya fue comprado", "", "error");</script><?php 
                        break;  
        
                    }
                        
                } else {
                    
                    ?><script>swal("Puesto no encontrado", "", "error");</script><?php 
                    break;
                    
                }
                
            } 
        
        } else {
            
            ?><script>swal("Selecciona una opci贸n", "", "warning");</script><?php 
    
        }
        
    }
    
    # si el bot贸n de borrar es accionado
    if (isset($_POST['borrar'])) {
    
        # recargamos la p谩gina 
        header("refresh:0");
    
    }

}

?>
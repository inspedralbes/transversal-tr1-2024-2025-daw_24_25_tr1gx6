export async function getProductoss() {
    try {
        const response = await fetch('http://localhost:8000/api/getProductos');

        //CONSULTAR SI LA CONEXION ES BUENA
        if (!response.ok) {
            throw new Error(`Error: ${response.status} - ${response.statusText}`);
        }
        const data = await response.json();
        console.log("Productos obtenidos:", data);
        return data;
    } catch (error) {
        console.error('Error al obtener productos:', error);
    }
}

export async function compraProductos(json) {
    try {
        const response = await fetch('http://localhost/api/createComandaArt', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(json),
        });
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        const data = response.json();
        console.log(data);
        return data;
    }catch(error){
        console.log(error);
    }
    
}
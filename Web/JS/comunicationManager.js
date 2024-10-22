export async function getProductoss() {
    try {
       const response = await fetch('http://localhost:8000/api/getProductos');

       //CONSULTAR SI LA CONEXION ES BUENA
        if (!response.ok) {
            throw new Error(`Error: ${response.status} - ${response.statusText}`);
        }

        const data = await response.json();
        console.log("data");
        return data;
    } catch (error) {
        console.error('Error al obtener productos:', error);
    }
}
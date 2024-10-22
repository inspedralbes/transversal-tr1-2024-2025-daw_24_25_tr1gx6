export async function getProductoss() {
    try {
       const response = await fetch('http://localhost:8000/api/getProductos');

        if (!response.ok) {
            throw new Error(`Error: ${response.status} - ${response.statusText}`);
        }

        const data = await response.json();
        console.log("data");
        
        return data; // Devolver los datos de los productos
    } catch (error) {
        console.error('Error al obtener productos:', error);
        throw error; // Opcional: puedes lanzar el error de nuevo si necesitas manejarlo en otro lugar
    }
}
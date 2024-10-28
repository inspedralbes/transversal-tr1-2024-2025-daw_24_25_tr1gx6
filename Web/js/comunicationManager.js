const HOST = 'http://localhost:8000/api';


/*-----------------------------------GET---------------------*/
export async function getProductoss() {
    try {
        const response = await fetch(HOST + '/getProductos');

        //CONSULTAR SI LA CONEXION ES BUENA
        if (!response.ok) {
            throw new Error(`Error: ${response.status} - ${response.statusText}`);
        }
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Error al obtener productos:', error);
    }
}


export async function getCategorias() {
    try {
        const response = await fetch(HOST + '/getCategory');
        const data = await response.json();
        return data;

    } catch (error) {
        console.log(error);
    }
}

export async function getMarcas() {
    try {
        const response = await fetch(HOST + '/getMarcas');
        const data = await response.json();
        return data;

    } catch (error) {
        console.log(error);
    }
}


/*----------------------------------------POST--------------------------------------*/
export async function checkoutProductos(json) {
    try {
        const response = await fetch(HOST + '/createComandaArt', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(json),
        });
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        const data = await response.json();
        console.log(data);
        return data;
    } catch (error) {
        console.log(error);
    }

}

export async function createComanda(json) {
    try {
        const response = await fetch(HOST + '/createComanda', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(json),
        });
        //CONSULTAR SI LA CONEXION ES BUENA
        if (!response.ok) {
            throw new Error(`Error: ${response.status} - ${response.statusText}`);
        }
        const data = await response.json();
        console.log(data);
        console.log(data.IdComanda);
        return data;
    } catch (error) {
        console.log(error);
    }

}

export async function pedidoUser(json) {
    try {
        const response = await fetch(HOST + '/pedidoUser', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(json),
        });
        //CONSULTAR SI LA CONEXION ES BUENA
        if (!response.ok) {
            throw new Error(`Error: ${response.status} - ${response.statusText}`);
        }
        const data = await response.json();
        return data;

    } catch (error) {
        console.log(error);
    }

}

export async function productobyID(json) {
    try {
        const response = await fetch(HOST + '/productoById', {
            method:'POST',
            headers: {
                'Content-Type':'application/json'
            },
            body:JSON.stringify(json),
        })
        const data = await response.json();

        console.log(data);
        
        return data;

    } catch (error) {
        console.log(error);
    }
}
<div v-if="divActivo == 'finalizarCompraDeCarrito'" class="carritoFinal">
            <h2>Finalizar pedido</h2>
            <form @submit.prevent="procesarCompra">
                <div>
                    <label for="nombre">Nombre</label>
                    <input type="text" v-model="nombre" id="nombre" placeholder="Nombre" required>
                </div>
                <div>
                    <label for="correoElectronico">Correo electronico</label>
                    <input type="email" v-model="correoElectronico" id="correoElectronico"
                        placeholder="Correo electronico" required>
                </div>
                <div>
                    <label for="direccion">Direccion de envio:</label>
                    <input type="text" v-model="direccion" id="direccion" placeholder="Direccion de envio" required>
                </div>
                <div>
                    <label for="tarjeta">Numero de tarjeta:</label>
                    <input type="number" v-model="datosUsuario.tarjeta" id="tarjeta" placeholder="Numero de tarjeta"
                        required>
                </div>
                <div>
                    <label for="expiracion">Fecha de expiración:</label>
                    <input type="text" v-model="datosUsuario.expiracion" id="expiracion" required>
                </div>
                <div>
                    <label for="cvv">CVV:</label>
                    <input type="text" v-model="datosUsuario.cvv" id="cvv" required>
                </div>
                <button type="submit">Confirmar compra</button>

                <button type="button" @click="volverACarrito">Volver al carrito</button>

            </form>
        </div>
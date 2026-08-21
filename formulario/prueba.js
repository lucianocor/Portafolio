const carrito =[
    {id:1,titulo:"Camiseta",precio:1000,cantidad:1},
    {id:2,titulo:"Pantalon",precio:2000,cantidad:1},
    {id:3,titulo:"Zapatilla",precio:3000,cantidad:0}
    
];
const Total=carrito.reduce((acc, e) => acc + (e.precio * e.cantidad), 0);


const filtrados=carrito.map((e,0) => e.titulo);

console.log(filtrados);

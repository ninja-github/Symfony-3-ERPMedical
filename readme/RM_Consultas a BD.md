Persistir objetos en la base de datos
-------------------------------------
**Insertar nuevo Dato**
```php
// Crear dato
$em = $this->getDoctrine()->getManager();
$product = new Product();
$product->setName('Keyboard');
$product->setPrice(19.99);
$product->setDescription('Ergonomic and stylish!');
// le dice a Doctrine que desea (eventualmente) guardar el Producto (aún no hay consultas)
$em->persist($product);
// realmente ejecuta las consultas (es decir, la consulta INSERT)
$em->flush();
```
**Editar Dato**
```php
// Editar dato
$em = $this->getDoctrine()->getManager();
$product = $em->getRepository(Product::class)->find($productId);
$product->setName('Keyboard');
$product->setPrice(19.99);
$product->setDescription('Ergonomic and stylish!');
// le dice a Doctrine que desea (eventualmente) guardar el Producto (aún no hay consultas)
$em->persist($product);
// realmente ejecuta las consultas (es decir, la consulta INSERT)
$em->flush();
```
**Eliminar Dato**
```php
// Eliminar dato
$em = $this->getDoctrine()->getManager();
$product = $em->getRepository(Product::class)->find($productId);
$em->remove($product);
$em->flush();
```

Obteniendo objetos de la base de datos. Búsquedas dentro del repositorio
------------------------------------------------------------------------
Primero cargamos **entity Manager**, para ello usamos `$em = $this->getDoctrine()->getManager();`.
Posteriormente cargamos el repositorio desde dónde haremos la búsqueda mediante `$product_repo = $em->getRepository("BackendBundle:Product");`.

**Consulta en Objetos**
```php
$em = $this->getDoctrine()->getManager();
$product_repo = $em->getRepository("BackendBundle:Product");
// consulta de un solo producto por su clave principal (generalmente "id")
$product = $product_repo->find($productId);
// nombres de métodos dinámicos para encontrar un solo producto basado en un valor de columna
$product = $product_repo-> findOneById ($productId);
$product = $product_repo-> findOneByName ('Teclado');
// nombres de métodos dinámicos para encontrar un grupo de productos basado en un valor de columna
$products = $product_repo-> findByPrice (19.99);
// encontrar * todos * productos
$all_product = $product_repo->findAll();
$order_product = product_repo->findBy(
    array('name' => 'Keyboard'),  /*columna*/
    array('price' => 'ASC')       /*orden*/
);
// consulta de un solo producto que coincida con el nombre y el precio
$product = $repository->findOneBy(
    array('name' => 'Keyboard', 'price' => 19.99)
);
// consulta de productos múltiples que coincidan con el nombre de pila, ordenados por precio
$products = $repository->findBy(
    array('name' => 'Keyboard'),
    array('price' => 'ASC')
);
```

**DQL**
```php
$em = $this->getDoctrine()->getManager();
$query = $em->createQuery(
    'SELECT p
    FROM AppBundle:Product p
    WHERE p.price > :price
    ORDER BY p.price ASC'
)->setParameter('price', 19.99);

$products = $query->getResult();  // Devuelve todos los resultados
$product = $query->setMaxResults(1)->getOneOrNullResult(); // Devuelve un resultado
```

**createQueryBuilder**
```php
$er = $this->getDoctrine()->getRepository(Product::class);

// createQueryBuilder () selecciona automáticamente FROM AppBundle: Product
// y lo alias a "p"
$query = $er->createQueryBuilder('p')
    ->where('p.price > :price')
    ->setParameter('price', '19.99')
    ->orderBy('p.price', 'ASC')
    ->getQuery();

$products = $query->getResult();
// para obtener solo un resultado:
$product = $query->setMaxResults(1)->getOneOrNullResult();
```

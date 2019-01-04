SELECT cargo.cargo, funciones_cargo.funciones, institucion_cargo.institucion, cargo.anoinicio, cargo.anofin
FROM cargo
inner join funciones_cargo ON funciones_cargo.idcargo= cargo.id
inner join institucion_cargo ON institucion_cargo.idcargo= cargo.id
<?php

/**
 * Contenido editorial Sede Electrónica DGT (español).
 * Alineado con la estructura y mensajes de sede.dgt.gob.es.
 */
$content = [
    'es' => [
        'role' => 'Sede Electrónica de la Dirección General de Tráfico (DGT).',
        'intro' => [
            'La Sede Electrónica es el canal oficial para realizar trámites con la DGT por internet, con la misma validez que en las oficinas cuando el procedimiento lo permite.',
        ],
        'body' => [
            'Desde aquí puede gestionar permisos de conducir, vehículos, multas, tasas, cita previa y consulta de expedientes. Para la mayoría de trámites debe identificarse con Cl@ve, certificado electrónico o DNI electrónico.',
            'Si dispone de cuenta en este portal de demostración, también puede acceder a miDGT para ver su permiso digital, puntos, notificaciones y pagos simulados.',
        ],
        'requirements' => [
            'Conexión a internet y navegador actualizado.',
            'Identificación: Cl@ve, certificado electrónico cualificado o DNIe.',
            'Para trámites vinculados a un expediente: NIE/DNI y datos del solicitante.',
        ],
        'functions' => [
            'Solicitud y renovación de permiso de conducir',
            'Duplicado y canje de permisos',
            'Informe y gestión de vehículos',
            'Consulta y pago de multas',
            'Pago de tasas y descarga de justificantes',
            'Cita previa en oficinas DGT',
            'Verificación de documentos emitidos',
        ],
    ],

    'es_acceso' => [
        'role' => 'Punto de identificación para acceder a los trámites de la Sede.',
        'intro' => [
            'Antes de iniciar un trámite debe acreditarse su identidad mediante uno de los sistemas de identificación electrónica admitidos por la Administración General del Estado.',
        ],
        'body' => [
            'Seleccione Cl@ve si dispone de usuario y contraseña o de la app Cl@ve Móvil. Utilice certificado electrónico si tiene un certificado cualificado instalado. Con DNIe/NIE electrónico puede identificarse con lector de tarjetas y PIN.',
        ],
        'requirements' => [
            'Cl@ve permanente, Cl@ve Móvil, certificado FNMT/Camerfirma u otro cualificado, o DNIe con lector.',
        ],
    ],

    'es_acceso_clave' => [
        'role' => 'Sistema de identificación Cl@ve del Gobierno de España.',
        'intro' => [
            'Cl@ve unifica el acceso a servicios de la DGT y otras administraciones con un único identificador digital.',
        ],
        'body' => [
            'Puede registrarse en la plataforma Cl@ve, conectarse si ya está dado de alta, o elegir Cl@ve Móvil desde la pantalla de la plataforma de identificación.',
        ],
        'functions' => [
            'Alta en Cl@ve (registro)',
            'Conexión con usuario y contraseña',
            'Cl@ve Móvil con PIN',
            'Certificado electrónico en la misma plataforma',
        ],
    ],

    'es_permisos-de-conducir' => [
        'role' => 'Permisos de conducir — Sede Electrónica DGT.',
        'intro' => [
            'Selecciona cualquiera de los servicios de esta sección: obtención y renovación, puntos, canje, permiso internacional, exámenes y cambio de dirección para notificaciones.',
        ],
        'body' => [
            'Encuentra información relativa a cada trámite. Cada procedimiento tiene requisitos documentales y tasas específicas; comprueba si puede realizarse en línea o requiere cita previa.',
        ],
        'functions' => [
            'Obtención y gestión de permisos',
            'Renovación por caducidad',
            'Duplicado',
            'Canje de permiso extranjero',
            'Permiso internacional de conducción',
            'Consulta de puntos del permiso',
            'Estado de tramitación de solicitudes',
            'Cambio de dirección para notificaciones',
        ],
    ],

    'es_permisos-de-conducir_obtencion-y-gestion-de-permisos' => [
        'role' => 'Procedimientos de alta, modificación y seguimiento del permiso.',
        'intro' => [
            'Agrupa la solicitud de nuevos permisos, inscripción a exámenes, traslado de expediente entre provincias y consulta del estado de sus solicitudes.',
        ],
        'body' => [
            'Para obtener el primer permiso deberá superar las pruebas teórica y práctica en un centro autorizado. Los permisos por caducidad o pérdida de vigencia se tramitan en apartados específicos de renovación o duplicado.',
        ],
        'steps' => [
            'Comprobar requisitos de edad y documentación.',
            'Inscribirse en autoescuela o presentar examen si procede.',
            'Abonar tasas correspondientes en la Sede.',
            'Seguir el estado del expediente hasta la emisión del permiso.',
        ],
        'functions' => [
            'Solicitud de permiso',
            'Inscripción a exámenes',
            'Traslado de expediente',
            'Modificación de datos del titular',
        ],
    ],

    'es_permisos-de-conducir_obtencion-y-gestion-de-permisos_renovacion-de-permiso-proximo-a-caducar' => [
        'role' => 'Renovación del permiso de conducir antes o después de su caducidad.',
        'intro' => [
            'El permiso tiene una validez limitada según la fecha de expedición y la fecha de caducidad que figura en el documento.',
        ],
        'body' => [
            'Puede renovar en línea si cumple los requisitos (edad, grupo, certificado médico cuando sea obligatorio). Si el permiso lleva caducado más de un plazo determinado, puede exigirse formación o pruebas adicionales.',
            'Disponga del justificante de pago de tasas y, si aplica, del reconocimiento médico en registro electrónico.',
        ],
        'steps' => [
            'Verificar fecha de caducidad en el permiso.',
            'Obtener certificado médico en centros autorizados si es obligatorio.',
            'Pagar la tasa de renovación en la Sede.',
            'Confirmar la solicitud y consultar el estado hasta recibir el nuevo permiso.',
        ],
        'requirements' => [
            'Identificación Cl@ve, certificado o DNIe.',
            'Fotografía y firma según modalidad de expedición.',
            'Certificado médico (grupos y edades que lo exijan).',
            'Tasa 2.1 u otras aplicables según normativa vigente.',
        ],
        'functions' => ['Renovación anticipada', 'Renovación en periodo de gracia', 'Consulta de estado'],
    ],

    'es_permisos-de-conducir_obtencion-y-gestion-de-permisos_duplicado-de-permisos' => [
        'role' => 'Expedición de un duplicado del permiso de conducir.',
        'intro' => [
            'Solicite duplicado si su permiso ha sido robado, extraviado o deteriorado, o si necesita una segunda copia conforme a la normativa.',
        ],
        'body' => [
            'En caso de robo o pérdida puede ser necesario presentar denuncia o declaración responsable. El duplicado mantiene las mismas autorizaciones y fechas que el permiso original en el registro de la DGT.',
        ],
        'requirements' => [
            'Identificación electrónica.',
            'Declaración o denuncia en supuestos de robo/extravío.',
            'Abono de tasa de duplicado.',
        ],
        'functions' => ['Duplicado por deterioro', 'Duplicado por pérdida o robo'],
    ],

    'es_permisos-de-conducir_canjes-de-permisos' => [
        'role' => 'Canje de permisos de conducción expedidos en el extranjero.',
        'intro' => [
            'Permite obtener un permiso español equivalente cuando se reside en España y se cumplen los convenios bilaterales o europeos aplicables.',
        ],
        'body' => [
            'No todos los países tienen convenio de canje directo; en algunos casos deberá superar pruebas o cursos. Consulte la lista de países y documentación traducida y legalizada.',
        ],
        'functions' => ['Canje de permiso de la Unión Europea', 'Canje de permisos de terceros países con convenio'],
    ],

    'es_permisos-de-conducir_canjes-de-permisos_canjes-de-permisos-extranjeros' => [
        'role' => 'Canje de un permiso expedido fuera de España.',
        'intro' => [
            'Procedimiento para titulares de permiso extranjero que establecen su residencia en España.',
        ],
        'body' => [
            'Aporte el permiso original o certificado del organismo expedidor, traducción jurada si no está en castellano, y documentación acreditativa de residencia. La DGT determinará si el canje es directo o requiere pruebas.',
        ],
        'requirements' => [
            'Permiso extranjero válido o certificado de vigencia.',
            'Empadronamiento o residencia acreditada.',
            'Fotografía y tasa de canje.',
        ],
    ],

    'es_permisos-de-conducir_obtencion-y-gestion-de-permisos_estado-de-la-tramitacion-del-permiso' => [
        'role' => 'Consulta del estado de sus solicitudes de permiso.',
        'intro' => [
            'Consulte en qué fase se encuentra un expediente de obtención, renovación o duplicado: pendiente de documentación, en estudio, denegado o permiso emitido.',
        ],
        'body' => [
            'Necesitará su NIE/DNI y, en su caso, el número de expediente facilitado al presentar la solicitud. En este portal de demostración puede usar la consulta de estado con código de verificación.',
        ],
        'functions' => ['Estados: pendiente', 'En tramitación', 'Resuelto', 'Emitido'],
    ],

    'es_permisos-de-conducir_direccion-para-notificaciones' => [
        'role' => 'Comunicación o modificación de la dirección postal y electrónica.',
        'intro' => [
            'La DGT envía notificaciones y requerimientos a la dirección registrada. Manténgala actualizada para no perder plazos administrativos.',
        ],
        'body' => [
            'Puede indicar domicilio en España o canal preferente de notificaciones electrónicas vinculado a su identificación.',
        ],
        'requirements' => ['Identificación Cl@ve o certificado', 'Dirección completa y código postal'],
    ],

    'es_permisos-de-conducir_consulta-de-puntos' => [
        'role' => 'Consulta del saldo de puntos del permiso de conducir.',
        'intro' => [
            'El permiso por puntos dispone de un saldo inicial; las infracciones graves y muy graves restan puntos y pueden conllevar la pérdida de vigencia.',
        ],
        'body' => [
            'Consulte el saldo actual, el historial de sanciones y los cursos de sensibilización. Los titulares con cuenta en miDGT pueden ver el detalle en su espacio personal.',
        ],
        'functions' => ['Saldo de puntos', 'Historial de infracciones', 'Información sobre recuperación de puntos'],
    ],

    'es_permisos-de-conducir_permiso-de-conduccion-internacional' => [
        'role' => 'Solicitud del permiso internacional de conducción.',
        'intro' => [
            'Documento complementario para conducir en determinados países que exigen el permiso internacional junto al permiso nacional.',
        ],
        'steps' => [
            'Compruebe que su permiso español está en vigor.',
            'Identifíquese con Cl@ve, certificado o DNIe en este portal o en la Sede oficial.',
            'Abone la tasa y recoja el permiso internacional en la oficina indicada o por los canales habilitados.',
        ],
        'functions' => [
            'Consulta de requisitos y países que exigen el permiso',
            'Solicitud con identificación electrónica',
            'Pago de tasas',
            'Seguimiento del expediente',
        ],
        'body' => [
            'Debe disponer de permiso español en vigor. La solicitud se realiza en la Sede o en oficina, con pago de tasa y plazo de expedición limitado.',
        ],
        'requirements' => ['Permiso de conducir español vigente', 'Tasa correspondiente', 'Identificación electrónica'],
    ],

    'es_vehiculos' => [
        'role' => 'Trámites de vehículos en la Sede Electrónica DGT.',
        'intro' => [
            'Realiza trámites relacionados con tus vehículos: matriculación, transferencias o notificación de venta, altas, bajas y rehabilitaciones.',
        ],
        'body' => [
            'También puedes obtener duplicado de la documentación, consultar el distintivo ambiental o informes de un vehículo, gestionar cambios en el domicilio fiscal del vehículo o comunicar un conductor habitual para tu vehículo.',
            'Seleccione el trámite en el listado inferior o acceda a la sección correspondiente. Los enlaces marcados como «Sede oficial» abren el servicio telemático en sede.dgt.gob.es.',
        ],
        'functions' => [
            'Informe completo de vehículo',
            'Transferencias de vehículos',
            'Matriculación y bajas',
            'Consulta de cargas o gravámenes',
        ],
    ],

    'es_vehiculos_informacion-de-vehiculos_informe-de-un-vehiculo' => [
        'role' => 'Informe de un vehículo a partir de su matrícula o bastidor.',
        'intro' => [
            'Documento oficial con datos técnicos, titularidad, historial de ITV y otras anotaciones registradas.',
        ],
        'body' => [
            'Útil antes de comprar un vehículo de segunda mano o para comprobar la situación administrativa. En este entorno de demostración el informe se simula tras identificarse.',
        ],
        'requirements' => ['Matrícula o número de bastidor', 'Identificación del solicitante', 'Pago de tasa de informe'],
        'functions' => ['Datos del vehículo', 'ITV', 'Titulares anteriores', 'Indicadores de leasing o renting'],
    ],

    'es_multas' => [
        'role' => 'Consulta y gestión de sanciones por infracciones de tráfico.',
        'intro' => [
            'Acceda a multas impuestas por la DGT o notificadas a través del registro del conductor: importe, expediente, puntos y plazo de pago bonificado.',
        ],
        'body' => [
            'Puede pagar con descuento dentro del plazo voluntario, presentar alegaciones o recurso, y consultar el historial. Identifíquese para ver las sanciones asociadas a su permiso.',
        ],
        'functions' => [
            'Consulta de multas pendientes',
            'Pago electrónico',
            'Presentación de recurso o alegaciones',
            'Descarga de justificante de pago',
        ],
    ],

    'es_otros-tramites_pago-de-tasas' => [
        'role' => 'Pago de tasas por servicios y trámites de la DGT.',
        'intro' => [
            'Las tasas deben abonarse para tramitar permisos, transferencias, informes y otros servicios. El pago en la Sede genera justificante válido para el expediente.',
        ],
        'body' => [
            'Seleccione el modelo de tasa (código), verifique el importe y pague con tarjeta u otros medios admitidos. Guarde el justificante PDF con el código seguro de verificación.',
        ],
        'functions' => ['Consulta de tasas pendientes', 'Pago en línea', 'Descarga de justificante'],
    ],

    'es_otros-tramites_cita-previa' => [
        'role' => 'Solicitud de cita previa en oficinas y centros de la DGT.',
        'intro' => [
            'Algunos trámites exigen presencia física: entrega de documentación, pruebas prácticas, o gestiones que no están telemáticas.',
        ],
        'body' => [
            'Elija provincia, oficina, tipo de trámite y fecha/hora disponible. Recibirá confirmación por correo o SMS. Llegue con la documentación indicada para ese procedimiento.',
        ],
        'steps' => [
            'Seleccionar oficina y servicio.',
            'Elegir día y hora libres.',
            'Confirmar cita y anotar referencia.',
            'Acudir con DNI/NIE y documentación del trámite.',
        ],
        'functions' => ['Cita para permisos', 'Cita para vehículos', 'Cita para otros trámites'],
    ],

    'es_otros-tramites_verificacion-de-documentos' => [
        'role' => 'Comprobación de autenticidad de documentos emitidos por la DGT.',
        'intro' => [
            'Terceros pueden verificar permisos, informes o justificantes mediante el código seguro de verificación impreso en el documento.',
        ],
        'body' => [
            'Introduzca el código único sin necesidad de identificarse como titular. El sistema indicará si el documento es válido y no ha sido revocado.',
        ],
        'functions' => ['Validación por código', 'Estado del documento', 'Fecha de emisión'],
    ],

    'midgt' => [
        'role' => 'Espacio personal del conductor en la DGT.',
        'intro' => [
            'miDGT concentra permiso digital, vehículos, notificaciones, multas, citas y mensajes de la DGT en un solo acceso.',
        ],
        'body' => [
            'Identifíquese con su cuenta del portal de demostración o mediante los métodos oficiales en el entorno real. Desde el panel puede descargar el permiso en el móvil, consultar puntos y gestionar pagos simulados.',
        ],
        'functions' => [
            'Permiso de conducir digital',
            'Notificaciones y avisos',
            'Mis vehículos',
            'Multas y pagos',
            'Cita previa',
            'Mi perfil y datos de contacto',
        ],
    ],
];

return array_replace($content, require __DIR__.'/sede_content_extra.php');

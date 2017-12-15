@component('mail::message')
# Bienvenido estimado(a) {{$NombreCompleto}}, a continuación te presentamos las credenciales con las que podras iniciar sesión, en algunas de las aplicaciones internas de Grupo Sánchez

@component('mail::panel')
**Usuario:** {{$UName}}<br>
**Password:**{{$Pwd}}
@endcomponent


Gracias por colaborar con nosotros,<br>
{{ config('app.name') }}
@endcomponent

# How to implement the authentication

Please find below the steps to understand the authentication process :
 
## User entity

The interface's users are represented by a User entity. It implements the UserInterface which provides methods used by the firewall and authentication system for credentials checks.

```/**
  * @ORM\Table("user")
  * @ORM\Entity
  * @UniqueEntity("email")
  */
 class User implements UserInterface
 {
    //...
 }
```

## Setup security.yml

###Provider :
```
security:
    providers:
        doctrine:
            entity:
                class: AppBundle:User
                property: username
```
Indicates to Symfony where can be found the user, in User entity and the defines which attribute is used for authentication.

###Password encryption :
```
security:
    encoders:
        AppBundle\Entity\User: bcrypt
```
Bcrypt encoder is used to encrypt the passwords before recording in Database

###Firewall :
```
security:
    firewalls:
        dev:
            pattern: ^/(_(profiler|wdt)|css|images|js)/
            security: false

        main:
            anonymous: ~
            pattern: ^/
            form_login:
                login_path: login
                check_path: login_check
                always_use_default_target_path:  true
                default_target_path:  /
            logout: ~
            access_denied_handler: AppBundle\Security\AccessDeniedHandler
```
The firewall defines the authentication's process. The credentials are entered in the form_login with the route login_pah : login.

###Roles hierarchy
```
security:
    role_hierarchy:
        ROLE_ADMIN: ROLE_USER
```
indicates that the ROLE_ADMIN has the same rights than the ROLE_USER and above.

###Access control
```
security:
    access_control:
        - { path: ^/login, roles: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: ^/users, roles: ROLE_ADMIN}
        - { path: ^/, roles: ROLE_USER }
```
The access control is set here :
*   the path /login is accessible to anyone
*   the path /users only to logged user with the ROLE_ADMIN
*   the path / to all logged users

##Security Controller
The SecurityController : namespace AppBundle\Controller defines how works the authentication process and the error message sent to the View. 

##Login Form
The form UserForm display the fields to be completed to create a new User :
```
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, ['label' => "Nom d'utilisateur"])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les deux mots de passe doivent correspondre.',
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Tapez le mot de passe à nouveau'],
            ])
            ->add('email', EmailType::class, ['label' => 'Adresse email'])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Rôle utilisateur' => 'ROLE_USER',
                    'Rôle administrateur' => 'ROLE_ADMIN',
                ],
                'multiple' => true
            ])
        ;
    }
```

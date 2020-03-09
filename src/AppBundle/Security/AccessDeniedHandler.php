<?php

namespace AppBundle\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    /**
     * @param  Request               $request
     * @param  AccessDeniedException $accessDeniedException
     * @return Response|null
     */
    public function handle(Request $request, AccessDeniedException $accessDeniedException = null)
    {

    ?>
    <script>
        alert('Cette page a un accès limité. Vous devez avoir le rôle administrateur.');
        history.back();
    </script>
    <?php
        return new Response('', 403);
    }
}

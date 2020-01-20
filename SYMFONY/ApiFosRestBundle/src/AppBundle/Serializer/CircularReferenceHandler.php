<?php
namespace AppBundle\Serializer;

use AppBundle\Entity\Note;
use AppBundle\Entity\Task;
use AppBundle\Entity\TaskList;
use Symfony\Component\Routing\Router;

class CircularReferenceHandler{

    /**
     * @var Router
     */
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function __invoke($object)
    {
        return $object->getId();

       /* switch ($object){
            case $object instanceof TaskList:
                return $this->router->generate('get_list',['taskList' => $object->getId()]);
                break;

            case $object instanceof Task:
                return $this->router->generate('get_task',['id' => $object->getId()]);
                break;

            case $object instanceof Note:
                return $this->router->generate('get_note',['id' => $object->getId()]);
                break;
        }*/
    }
}
<?php


namespace App\Controller\Admin;


use App\Form\ApiKeyFormType;
use App\Service\ParameterService;
use Exception;
use Futurolan\WeezeventBundle\Client\WeezeventClient;
use GuzzleHttp\Exception\GuzzleException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminApiKeyController
 * @package App\Controller\Admin
 * @Security("is_granted('ROLE_SUPER_ADMIN')")
 */
class AdminApiKeyController extends AbstractController
{

    /** @var ParameterService */
    private $parameterService;

    /** @var WeezeventClient */
    private $weezeventClient;

    /**
     * AdminApiKeyController constructor.
     * @param ParameterService $parameterService
     * @param WeezeventClient $weezeventClient
     */
    public function __construct(ParameterService $parameterService, WeezeventClient $weezeventClient)
    {
        $this->parameterService = $parameterService;
        $this->weezeventClient = $weezeventClient;
    }

    /**
     * @Route("/admin/apiKey", name="adminApiKeyPage")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function apiKeyForm(Request $request)
    {
        $form = $this->createForm(ApiKeyFormType::class, [
            'apiToken' => $this->parameterService->get($this->parameterService::API_TOKEN),
        ]);

        $form->handleRequest($request);
        if ( $form->isSubmitted() && $form->isValid() ) {

            $data = $form->getData();

            if ( key_exists('apiToken', $data) ) { $this->parameterService->set($this->parameterService::API_TOKEN, $data['apiToken']); }

            $this->addFlash('success', "La clef API a bien été enregistrée.");

            return $this->redirectToRoute('adminPage');
        }

        return $this->render('admin/adminApiKeyPage.html.twig', [
            'apiKeyForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/regenToken", methods="GET", name="adminApiRegenTokenApi")
     * @return JsonResponse
     */
    public function getNewToken()
    {
        try{
            return new JsonResponse(['data' => $this->weezeventClient->getNewToken()], );
        } catch(Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        } catch(GuzzleException $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }

    }
}
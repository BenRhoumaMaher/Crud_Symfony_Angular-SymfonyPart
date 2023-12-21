<?php

namespace App\Controller\Api;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProjectController extends AbstractController
{
    private ProjectRepository $projectRepository;

    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }


    #[Route("/api/projects", name:"project_index", methods:"GET")]
    public function index(): JsonResponse
    {
        $projects = $this->projectRepository->findAll();

        $data = [];

        foreach ($projects as $project) {
            $data[] = [
                'projectID' => $project->getProjectID(),
                'projectName' => $project->getProjectName(),
                'dateOfStart' => $project->getDateOfStart()->format('Y-m-d'),
                'teamSize' => $project->getTeamSize(),
            ];
        }
        $response = $this->json($data);
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }

    #[Route("/api/newproject", name:"project_new", methods:"POST")]
public function new(Request $request, EntityManagerInterface $entityManager): JsonResponse
{
    $project = new Project();
    $project->setProjectName((string) $request->request->get('projectName'));
    $project->setDateOfStart(new \DateTime($request->request->get('dateOfStart')));
    $project->setTeamSize((int) $request->request->get('teamSize'));

    $entityManager->persist($project);
    $entityManager->flush();

    $data = [
        'projectID' => $project->getProjectID(),
        'projectName' => (string) $project->getProjectName(),
        'dateOfStart' => $project->getDateOfStart()->format('Y-m-d'),
        'teamSize' => (int) $project->getTeamSize(),
    ];

    $response = $this->json($data);
    $response->headers->set('Access-Control-Allow-Origin', '*');

    return $response;
}


    #[Route("/api/projects/{projectID}", name:"project_show", methods:"GET")]
    public function show(int $projectID): JsonResponse
    {
        $project = $this->projectRepository->find($projectID);

        if (!$project) {
            return $this->json('No project found for id ' . $projectID, 404);
        }

        $data = [
            'projectID' => $project->getProjectID(),
            'projectName' => $project->getProjectName(),
            'dateOfStart' => $project->getDateOfStart()->format('Y-m-d'),
            'teamSize' => $project->getTeamSize(),
        ];

        return $this->json($data);
    }

    #[Route("/api/projects/{projectID}", name:"project_edit", methods:"PUT")]
    public function edit(Request $request, int $projectID, EntityManagerInterface $entityManager): JsonResponse
    {
        $project = $this->projectRepository->find($projectID);

        if (!$project) {
            return $this->json('No project found for id ' . $projectID, 404);
        }

        $content = json_decode($request->getContent());

        $project->setProjectName($content->projectName);
        $project->setDateOfStart(new \DateTime($content->dateOfStart));
        $project->setTeamSize((int) $content->teamSize);

        $entityManager->flush();

        $data = [
            'projectID' => $project->getProjectID(),
            'projectName' => $project->getProjectName(),
            'dateOfStart' => $project->getDateOfStart()->format('Y-m-d'),
            'teamSize' => $project->getTeamSize(),
        ];

        return $this->json($data);
    }

    #[Route("/api/projects/{projectID}", name:"project_delete", methods:"DELETE")]
    public function delete(int $projectID, EntityManagerInterface $entityManager): JsonResponse
    {
        $project = $this->projectRepository->find($projectID);

        if (!$project) {
            return $this->json('No project found for id ' . $projectID, 404);
        }

        $entityManager->remove($project);
        $entityManager->flush();

        return $this->json('Deleted a project successfully with id ' . $projectID);
    }
    #[Route("/api/projects/search/{searchBy}/{searchText}", name:"project_search", methods:"GET")]
    public function searchProjects(Request $request, string $searchBy, string $searchText): JsonResponse
    {

        $projects = $this->projectRepository->searchProjects($searchBy, $searchText);

        $data = [];

        foreach ($projects as $project) {
            $data[] = [
                'projectID' => $project->getProjectID(),
                'projectName' => $project->getProjectName(),
                'dateOfStart' => $project->getDateOfStart()->format('Y-m-d'),
                'teamSize' => $project->getTeamSize(),
            ];
        }

        $response = $this->json($data);
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }
}
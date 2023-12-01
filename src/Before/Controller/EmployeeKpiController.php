<?php

declare(strict_types=1);

namespace App\Before\Controller;

use App\After\Infrustructure\Controller\EmployeeKpiCrudController;
use App\After\Infrustructure\Controller\EmployeeKpiTableGenerator;
use App\After\Infrustructure\Controller\Exception;
use App\After\Infrustructure\Controller\JsonResponse;
use App\After\Infrustructure\Controller\Request;
use App\After\Infrustructure\Controller\Response;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Psr\Log\LoggerInterface;

class EmployeeKpiController extends AbstractCrudController
{
    public function __construct(readonly LoggerInterface $logger)
    {
    }

    public function showQuarterlyKpi(Request $request): Response
    {
        try {
            $monthlyKpi = $this->kpiRepository->findAllWithFullName();
            $quarterlyKpi = $this->kpiRepository->getQuarterlyKpi();

            if ($request->isXmlHttpRequest()) {
                $filterYear = $request->request->get('year');
                $kpiService = new EmployeeKpiTableGenerator($filterYear, $quarterlyKpi, $monthlyKpi);
                $table = $kpiService->generateTable();

                return new JsonResponse([
                    'columns' => $table['columns'],
                    'rows' => $table['rows'],
                ]);
            }

            $currentYear = date('Y');
            $kpiService = new EmployeeKpiTableGenerator($currentYear, $quarterlyKpi, $monthlyKpi);
            $table = $kpiService->generateTable();

            return $this->render('admin/employee_kpi/show_quarterly_kpi.html.twig', [
                'columns' => $table['columns'],
                'rows' => $table['rows'],
            ]);
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());

            return $this->render('admin/error/exception.html.twig', [
                'exception' => $e,
            ]);
        }
    }

    public function newQuarterlyKpi(Request $request, EntityManagerInterface $entityManager): Response
    {
        try {
            $date = $request->query->get('date');
            $employees = $entityManager->getRepository(EmployeeKpi::class)->findEmployeeWithoutKpi($date);
            $formsFields = EmployeeKpiFormGenerator::generate($date, $employees);
            $forms = $this->createFormBuilder($formsFields)->add('employee_kpi', CollectionType::class, [
                'entry_type' => EmployeeKpiType::class,
            ])->getForm();
            $forms->handleRequest($request);

            if ($forms->isSubmitted() && $forms->isValid()) {
                foreach ($forms->get('employee_kpi')->getData() as $kpi) {
                    $newKpi = new EmployeeKpi();
                    $newKpi->setEmployee($kpi['employee']);
                    $newKpi->setDate($kpi['date']);
                    $newKpi->setPoints($kpi['points']);
                    $newKpi->setComment($kpi['comment']);
                    $entityManager->persist($newKpi);
                }
                $entityManager->flush();

                return $this->redirectToRoute('admin', [
                    'crudControllerFqcn' => EmployeeKpiCrudController::class,
                ]);
            }

            return $this->render('admin/employee_kpi/new_quarterly_kpi.html.twig', [
                'controller' => EmployeeKpiCrudController::class,
                'forms' => $forms,
            ]);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());

            return $this->render('admin/error/exception.html.twig', [
                'exception' => $e,
            ]);
        }
    }
}
<?php

declare(strict_types=1);

namespace App\After\Infrustructure\Controller;

use Psr\Log\LoggerInterface;
use App\After\Application\Service\TableGenerator\EmployeeKpiTableGenerator;

class EmployeeKpiController extends AbstractCrudController
{
    public function __construct(readonly LoggerInterface $logger)
    {
    }

    public function showQuarterlyKpi(Request $request, EmployeeKpiTableGenerator $tableGenerator): Response
    {
        try {
            if ($request->isXmlHttpRequest()) {
                $filterYear = $request->request->get('year');
                $table = $tableGenerator->generateTable($filterYear);

                return new JsonResponse([
                    'columns' => $table['columns'],
                    'rows' => $table['rows'],
                ]);
            }

            $table = $tableGenerator->generateTable(date('Y'));

            return $this->render('admin/employee_kpi/show_quarterly_kpi.html.twig', [
                'columns' => $table['columns'],
                'rows' => $table['rows'],
            ]);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());

            return $this->render('admin/error/exception.html.twig', [
                'exception' => $e,
            ]);
        }
    }

    public function newQuarterlyKpi(Request $request, EntityManagerInterface $entityManager, FormGeneratorInterface $formGenerator): Response
    {
        try {
            $date = $request->query->get('date');
            $formsFields = $formGenerator->generate($date);
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
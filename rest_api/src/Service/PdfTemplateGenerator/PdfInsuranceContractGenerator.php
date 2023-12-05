<?php

declare(strict_types=1);

namespace App\Service\PdfBuilder;

class PdfInsuranceContractGenerator extends AbstractPdfContractGenerator
{
    protected function addHeader(): string
    {
        return 'Insurance Contract';
    }

    protected function addPreamble(): string
    {
        return '1.1. Under this Agreement, the Insurer undertakes, upon the occurrence of an insured event, to pay the Insured Person (the Beneficiary) insurance compensation, and the Insured undertakes to pay the Insurer an insurance premium in the amount, in the manner and within the time limits stipulated by the Agreement.
              1.2. The insured person is (full name).
              1.3. The beneficiary is (full name).';
    }

    protected function addText(): string
    {
        return '2.1. An insured event under this Agreement is recognized as (an event upon the occurrence of which an obligation arisesinsurer to make an insurance payment)
              2.2. Events that occur as a result of: intentional actions of the Policyholder (the Insured person or the Beneficiary); the Insured person being under the influence of alcohol, drugs or toxic substances;    
              2.3. The insurer is obliged:
              2.3.1. Upon the occurrence of an insured event, pay the insurance amount in the amount, manner and terms established by this Agreement.
              2.4. The insurer has the right:
              2.4.1. Request from the Policyholder and the Insured Person (Beneficiary) information and information related to this Agreement.
              2.4.2. Check any information communicated to him by the Policyholder, the Insured Person and the Beneficiary, as well as information that has become known to the Insurer that is related to this Agreement.
              2.5. The policyholder is obliged:
              2.5.1. Inform the Insurer of the circumstances that are significant for determining the likelihood of the occurrence of an insured event, if these circumstances are unknown and should not be known to the Insurer.
              2.5.2. Provide the Insurer with the opportunity to unimpededly verify information related to this Agreement and provide all necessary documents and other evidence.
              2.5.3. Pay the insurance premium in the amount, manner and terms established by this Agreement.';
    }

    protected function addSignature(): string
    {
        return '12. SIGNATURES OF THE PARTIES
              Underwriter _______________
              Assured _______________';
    }
}

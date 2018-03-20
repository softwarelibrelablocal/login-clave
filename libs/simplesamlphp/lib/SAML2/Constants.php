<?php

//require_once('/var/simplesamlphp/lib/SAML2/Stork_RequestedAttribute.php');
require_once( 'Stork_RequestedAttribute.php' );

class StorkConstants {

	const SP_VC_FILE = '/var/simplesamlphp/STORK-info-SPs.xml';
	const STORKP_NS = 'urn:eu:stork:names:tc:STORK:1.0:protocol';
	const SAMLP_NS = 'urn:oasis:names:tc:SAML:2.0:protocol';
	const STORK_NS = 'urn:eu:stork:names:tc:STORK:1.0:assertion';

	//const ASSERTION_URL = 'https://www.rivasciudad.vm/wp-login.php?external_logged=ok';
	//const SPID = 'demo-sp-php';
	//const LOGOUT_RETURN_URL = 'https://www.rivasciudad.vm/wp-login.php?logout=ok';
	//const LOGOUT_SEND_URL = 'https://se-pasarela.clave.gob.es/Proxy/LogoutAction';

	const QAALEVEL = 'stork:QualityAuthenticationAssuranceLevel';
	const SPSECTOR = 'stork:spSector';
	const SPINST = 'stork:spInstitution';
	const SPAPP = 'stork:spApplication';
	const SPCOUNTRY = 'stork:spCountry';
	const EIDSS = 'storkp:eIDSectorShare';
	const EIDCSS = 'storkp:eIDCrossSectorShare';
	const EIDCBS = 'storkp:eIDCrossBorderShare';

	/*Tocar aquí para añadir atributos*/
	public static $idsPersonal = array(
		'DNI',
		'Nombre',
		'Apellidos',
		'inheritedFamilyName',
		'DNIe',
		'adoptedFamilyName',
		'gender',
		'dateOfBirth',
		'countryCodeOfBirth',
		'placeOfBirth',
		'nationalityCode',
		'maritalStatus',
		'eMail',
		'pseudonym',
		'age',
		'isAgeOver',
		'canonicalResidenceAddress',
		'signedDoc',
		'textResidenceAddress',
		'title',
		'residencePermit',
		'citizenQAALevel',
		'unknown',
		'registerType',
		'afirmaResponse'
	);

	public static $idsBusiness = array(
		'surnameOfHolder',
		'givenNameOfHolder',
		'dateOfBirthOfHolder',
		'studentIdentificationCode',
		'nameOfQualification',
		'nameOfTitle',
		'mainFieldsOfStudy',
		'nameOfAwardingInstitution',
		'statusOfAwardingInstitution',
		'languageOfInstruction',
		'languageOfAssesment',
		'levelOfQualification',
		'officialLengthOfProgramme',
		'accessRequirement',
		'modeOfStudy',
		'programmeRequirements',
		'programmeDetails',
		'gradingScheme',
		'gradingDistributionGuidance',
		'overallClassification',
		'accessToFurtherStudy',
		'professionalStatus',
		'additionalInformation',
		'additionalInformationSources',
		'certificationDate',
		'certificationCapacity',
		'higherEducationSystemInformation',
		'yearOfStudy',
		'averageGradeOfStudy',
		'studyRecommendation',
		'isEligibleForInternship',
		'isStudent',
		'isAcademicStaff',
		'isTeacherOf',
		'isCourseCoordinator',
		'isAdminStaff',
		'habilitation',
		'acTitle',
		'hasDegree',
		'hasAccountInBank',
		'isHealthCareProfessional'
	);

	public static $idsLegal = array(
		'eLPIdentifier',
		'legalName',
		'alternativeName',
		'type',
		'translatableType',
		'status',
		'activity',
		'registeredAddress',
		'registeredCanonicalAddress',
		'contactInformation',
		'fiscalNumber',
		'representative',
		'represented',
		'mandateContent'
	);


	/*
	 private static $confs = array(

		'stork:spSector' => 'DEMO-SP',
		'stork:spInstitution' => 'DEMO-SP',
		'stork:spApplication' => 'DEMO-SP',
		'storkp:eIDSectorShare' => 'true',
		'storkp:eIDCrossSectorShare' => 'true',
		'storkp:eIDCrossBorderShare' => 'true',
	);
	*/

	public static $attrs = array(
		'DNI.name'                             => 'eIdentifier',
		'DNI.uri'                              => 'http://www.stork.gov.eu/1.0/eIdentifier',
		'DNI.nameFormat'                       => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'DNI.value'                            => null,
		'Nombre.name'                          => 'givenName',
		'Nombre.uri'                           => 'http://www.stork.gov.eu/1.0/givenName',
		'Nombre.nameFormat'                    => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'Nombre.value'                         => null,
		'Apellidos.name'                       => 'surname',
		'Apellidos.uri'                        => 'http://www.stork.gov.eu/1.0/surname',
		'Apellidos.nameFormat'                 => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'Apellidos.value'                      => null,
		'inheritedFamilyName.name'             => 'inheritedFamilyName',
		'inheritedFamilyName.uri'              => 'http://www.stork.gov.eu/1.0/inheritedFamilyName',
		'inheritedFamilyName.nameFormat'       => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'inheritedFamilyName.value'            => null,
		'adoptedFamilyName.name'               => 'adoptedFamilyName',
		'adoptedFamilyName.uri'                => 'http://www.stork.gov.eu/1.0/adoptedFamilyName',
		'adoptedFamilyName.nameFormat'         => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'adoptedFamilyName.value'              => null,
		'DNIe.name'                            => 'isdnie',
		'DNIe.uri'                             => 'http://www.stork.gov.eu/1.0/isdnie',
		'DNIe.nameFormat'                      => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'DNIe.value'                           => null,
		'gender.name'                          => 'gender',
		'gender.uri'                           => 'http://www.stork.gov.eu/1.0/gender',
		'gender.nameFormat'                    => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'gender.value'                         => null,
		'dateOfBirth.name'                     => 'dateOfBirth',
		'dateOfBirth.uri'                      => 'http://www.stork.gov.eu/1.0/dateOfBirth',
		'dateOfBirth.nameFormat'               => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'dateOfBirth.value'                    => null,
		'countryCodeOfBirth.name'              => 'countryCodeOfBirth',
		'countryCodeOfBirth.uri'               => 'http://www.stork.gov.eu/1.0/countryCodeOfBirth',
		'countryCodeOfBirth.nameFormat'        => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'countryCodeOfBirth.value'             => null,
		'placeOfBirth.name'                    => 'placeOfBirth',
		'placeOfBirth.uri'                     => 'http://www.stork.gov.eu/1.0/countryCodeOfBirth',
		'placeOfBirth.nameFormat'              => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'placeOfBirth.value'                   => null,
		'nationalityCode.name'                 => 'nationalityCode',
		'nationalityCode.uri'                  => 'http://www.stork.gov.eu/1.0/nationalityCode',
		'nationalityCode.nameFormat'           => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'nationalityCode.value'                => null,
		'maritalStatus.name'                   => 'maritalStatus',
		'maritalStatus.uri'                    => 'http://www.stork.gov.eu/1.0/maritalStatus',
		'maritalStatus.nameFormat'             => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'maritalStatus.value'                  => null,
		'textResidenceAddress.name'            => 'textResidenceAddress',
		'textResidenceAddress.uri'             => 'http://www.stork.gov.eu/1.0/textResidenceAddress',
		'textResidenceAddress.nameFormat'      => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'textResidenceAddress.value'           => null,
		'canonicalResidenceAddress.name'       => 'canonicalResidenceAddress',
		'canonicalResidenceAddress.uri'        => 'http://www.stork.gov.eu/1.0/canonicalResidenceAddress',
		'canonicalResidenceAddress.nameFormat' => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'canonicalResidenceAddress.value'      => null,
		'eMail.name'                           => 'eMail',
		'eMail.uri'                            => 'http://www.stork.gov.eu/1.0/eMail',
		'eMail.nameFormat'                     => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'eMail.value'                          => null,
		'title.name'                           => 'title',
		'title.uri'                            => 'http://www.stork.gov.eu/1.0/title',
		'title.nameFormat'                     => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'title.value'                          => null,
		'residencePermit.name'                 => 'residencePermit',
		'residencePermit.uri'                  => 'http://www.stork.gov.eu/1.0/residencePermit',
		'residencePermit.nameFormat'           => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'residencePermit.value'                => null,
		'pseudonym.name'                       => 'pseudonym',
		'pseudonym.uri'                        => 'http://www.stork.gov.eu/1.0/pseudonym',
		'pseudonym.nameFormat'                 => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'pseudonym.value'                      => null,
		'age.name'                             => 'age',
		'age.uri'                              => 'http://www.stork.gov.eu/1.0/age',
		'age.nameFormat'                       => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'age.value'                            => null,
		'isAgeOver.name'                       => 'isAgeOver',
		'isAgeOver.uri'                        => 'http://www.stork.gov.eu/1.0/isAgeOver',
		'isAgeOver.nameFormat'                 => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'isAgeOver.value'                      => '18',
		'signedDoc.name'                       => 'signedDoc',
		'signedDoc.uri'                        => 'http://www.stork.gov.eu/1.0/signedDoc',
		'signedDoc.nameFormat'                 => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'signedDoc.value'                      => '<sl:CreateXMLSignatureRequest xmlns:sl="http://www.buergerkarte.at/namespaces/securitylayer/1.2#"><sl:KeyboxIdentifier>SecureSignatureKeypair</sl:KeyboxIdentifier><sl:DataObjectInfo Structure="enveloping"><sl:DataObject><sl:XMLContent>Ich bin ein einfacher Text.</sl:XMLContent></sl:DataObject><sl:TransformsInfo><sl:FinalDataMetaInfo><sl:MimeType>text/plain</sl:MimeType></sl:FinalDataMetaInfo></sl:TransformsInfo></sl:DataObjectInfo></sl:CreateXMLSignatureRequest>',
		'citizenQAALevel.name'                 => 'citizenQAALevel',
		'citizenQAALevel.uri'                  => 'http://www.stork.gov.eu/1.0/citizenQAALevel',
		'citizenQAALevel.nameFormat'           => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'citizenQAALevel.value'                => null,
		'unknown.name'                         => 'unknown',
		'unknown.uri'                          => 'http://www.stork.gov.eu/1.0/unknown',
		'unknown.nameFormat'                   => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'unknown.value'                        => null,
		'afirmaResponse.name'                  => 'afirmaResponse',
		'afirmaResponse.uri'                   => 'http://www.stork.gov.eu/1.0/afirmaResponse',
		'afirmaResponse.nameFormat'            => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'afirmaResponse.value'                 => null,
		'registerType.name'                    => 'registerType',
		'registerType.uri'                     => 'http://www.stork.gov.eu/1.0/registerType',
		'registerType.nameFormat'              => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'registerType.value'                   => null,


		'surnameOfHolder.name'                        => 'surnameOfHolder',
		'surnameOfHolder.uri'                         => 'http://www.stork.gov.eu/1.0/surnameOfHolder',
		'surnameOfHolder.nameFormat'                  => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'surnameOfHolder.value'                       => null,
		'givenNameOfHolder.name'                      => 'givenNameOfHolder',
		'givenNameOfHolder.uri'                       => 'http://www.stork.gov.eu/1.0/givenNameOfHolder',
		'givenNameOfHolder.nameFormat'                => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'givenNameOfHolder.value'                     => null,
		'dateOfBirthOfHolder.name'                    => 'dateOfBirthOfHolder',
		'dateOfBirthOfHolder.uri'                     => 'http://www.stork.gov.eu/1.0/dateOfBirthOfHolder',
		'dateOfBirthOfHolder.nameFormat'              => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'dateOfBirthOfHolder.value'                   => null,
		'studentIdentificationCode.name'              => 'studentIdentificationCode',
		'studentIdentificationCode.uri'               => 'http://www.stork.gov.eu/1.0/studentIdentificationCode',
		'studentIdentificationCode.nameFormat'        => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'studentIdentificationCode.value'             => null,
		'nameOfQualification.name'                    => 'nameOfQualification',
		'nameOfQualification.uri'                     => 'http://www.stork.gov.eu/1.0/nameOfQualification',
		'nameOfQualification.nameFormat'              => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'nameOfQualification.value'                   => null,
		'nameOfTitle.name'                            => 'nameOfTitle',
		'nameOfTitle.uri'                             => 'http://www.stork.gov.eu/1.0/nameOfTitle',
		'nameOfTitle.nameFormat'                      => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'nameOfTitle.value'                           => null,
		'mainFieldsOfStudy.name'                      => 'mainFieldsOfStudy',
		'mainFieldsOfStudy.uri'                       => 'http://www.stork.gov.eu/1.0/mainFieldsOfStudy',
		'mainFieldsOfStudy.nameFormat'                => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'mainFieldsOfStudy.value'                     => null,
		'nameOfAwardingInstitution.name'              => 'nameOfAwardingInstitution',
		'nameOfAwardingInstitution.uri'               => 'http://www.stork.gov.eu/1.0/nameOfAwardingInstitution',
		'nameOfAwardingInstitution.nameFormat'        => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'nameOfAwardingInstitution.value'             => null,
		'statusOfAwardingInstitution.name'            => 'statusOfAwardingInstitution',
		'statusOfAwardingInstitution.uri'             => 'http://www.stork.gov.eu/1.0/statusOfAwardingInstitution',
		'statusOfAwardingInstitution.nameFormat'      => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'statusOfAwardingInstitution.value'           => null,
		'languageOfInstruction.name'                  => 'languageOfInstruction',
		'languageOfInstruction.uri'                   => 'http://www.stork.gov.eu/1.0/languageOfInstruction',
		'languageOfInstruction.nameFormat'            => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'languageOfInstruction.value'                 => null,
		'languageOfAssesment.name'                    => 'languageOfAssesment',
		'languageOfAssesment.uri'                     => 'http://www.stork.gov.eu/1.0/languageOfAssesment',
		'languageOfAssesment.nameFormat'              => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'languageOfAssesment.value'                   => null,
		'levelOfQualification.name'                   => 'levelOfQualification',
		'levelOfQualification.uri'                    => 'http://www.stork.gov.eu/1.0/levelOfQualification',
		'levelOfQualification.nameFormat'             => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'levelOfQualification.value'                  => null,
		'officialLengthOfProgramme.name'              => 'officialLengthOfProgramme',
		'officialLengthOfProgramme.uri'               => 'http://www.stork.gov.eu/1.0/officialLengthOfProgramme',
		'officialLengthOfProgramme.nameFormat'        => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'officialLengthOfProgramme.value'             => null,
		'accessRequirement.name'                      => 'accessRequirement',
		'accessRequirement.uri'                       => 'http://www.stork.gov.eu/1.0/accessRequirement',
		'accessRequirement.nameFormat'                => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'accessRequirement.value'                     => null,
		'modeOfStudy.name'                            => 'modeOfStudy',
		'modeOfStudy.uri'                             => 'http://www.stork.gov.eu/1.0/modeOfStudy',
		'modeOfStudy.nameFormat'                      => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'modeOfStudy.value'                           => null,
		'programmeRequirements.name'                  => 'programmeRequirements',
		'programmeRequirements.uri'                   => 'http://www.stork.gov.eu/1.0/programmeRequirements',
		'programmeRequirements.nameFormat'            => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'programmeRequirements.value'                 => null,
		'programmeDetails.name'                       => 'programmeDetails',
		'programmeDetails.uri'                        => 'http://www.stork.gov.eu/1.0/programmeDetails',
		'programmeDetails.nameFormat'                 => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'programmeDetails.value'                      => null,
		'gradingScheme.name'                          => 'gradingScheme',
		'gradingScheme.uri'                           => 'http://www.stork.gov.eu/1.0/gradingScheme',
		'gradingScheme.nameFormat'                    => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'gradingScheme.value'                         => null,
		'gradingDistributionGuidance.name'            => 'gradingDistributionGuidance',
		'gradingDistributionGuidance.uri'             => 'http://www.stork.gov.eu/1.0/gradingDistributionGuidance',
		'gradingDistributionGuidance.nameFormat'      => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'gradingDistributionGuidance.value'           => null,
		'overallClassification.name'                  => 'overallClassification',
		'overallClassification.uri'                   => 'http://www.stork.gov.eu/1.0/overallClassification',
		'overallClassification.nameFormat'            => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'overallClassification.value'                 => null,
		'accessToFurtherStudy.name'                   => 'accessToFurtherStudy',
		'accessToFurtherStudy.uri'                    => 'http://www.stork.gov.eu/1.0/accessToFurtherStudy',
		'accessToFurtherStudy.nameFormat'             => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'accessToFurtherStudy.value'                  => null,
		'professionalStatus.name'                     => 'professionalStatus',
		'professionalStatus.uri'                      => 'http://www.stork.gov.eu/1.0/professionalStatus',
		'professionalStatus.nameFormat'               => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'professionalStatus.value'                    => null,
		'additionalInformation.name'                  => 'additionalInformation',
		'additionalInformation.uri'                   => 'http://www.stork.gov.eu/1.0/additionalInformation',
		'additionalInformation.nameFormat'            => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'additionalInformation.value'                 => null,
		'additionalInformationSources.name'           => 'additionalInformationSources',
		'additionalInformationSources.uri'            => 'http://www.stork.gov.eu/1.0/additionalInformationSources',
		'additionalInformationSources.nameFormat'     => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'additionalInformationSources.value'          => null,
		'certificationDate.name'                      => 'certificationDate',
		'certificationDate.uri'                       => 'http://www.stork.gov.eu/1.0/certificationDate',
		'certificationDate.nameFormat'                => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'certificationDate.value'                     => null,
		'certificationCapacity.name'                  => 'certificationCapacity',
		'certificationCapacity.uri'                   => 'http://www.stork.gov.eu/1.0/certificationCapacity',
		'certificationCapacity.nameFormat'            => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'certificationCapacity.value'                 => null,
		'higherEducationSystemInformation.name'       => 'higherEducationSystemInformation',
		'higherEducationSystemInformation.uri'        => 'http://www.stork.gov.eu/1.0/higherEducationSystemInformation',
		'higherEducationSystemInformation.nameFormat' => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'higherEducationSystemInformation.value'      => null,
		'yearOfStudy.name'                            => 'yearOfStudy',
		'yearOfStudy.uri'                             => 'http://www.stork.gov.eu/1.0/yearOfStudy',
		'yearOfStudy.nameFormat'                      => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'yearOfStudy.value'                           => null,
		'averageGradeOfStudy.name'                    => 'averageGradeOfStudy',
		'averageGradeOfStudy.uri'                     => 'http://www.stork.gov.eu/1.0/averageGradeOfStudy',
		'averageGradeOfStudy.nameFormat'              => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'averageGradeOfStudy.value'                   => null,
		'studyRecommendation.name'                    => 'studyRecommendation',
		'studyRecommendation.uri'                     => 'http://www.stork.gov.eu/1.0/studyRecommendation',
		'studyRecommendation.nameFormat'              => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'studyRecommendation.value'                   => null,
		'isEligibleForInternship.name'                => 'isEligibleForInternship',
		'isEligibleForInternship.uri'                 => 'http://www.stork.gov.eu/1.0/isEligibleForInternship',
		'isEligibleForInternship.nameFormat'          => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'isEligibleForInternship.value'               => null,
		'isStudent.name'                              => 'isStudent',
		'isStudent.uri'                               => 'http://www.stork.gov.eu/1.0/isStudent',
		'isStudent.nameFormat'                        => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'isStudent.value'                             => null,
		'isAcademicStaff.name'                        => 'isAcademicStaff',
		'isAcademicStaff.uri'                         => 'http://www.stork.gov.eu/1.0/isAcademicStaff',
		'isAcademicStaff.nameFormat'                  => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'isAcademicStaff.value'                       => null,
		'isTeacherOf.name'                            => 'isTeacherOf',
		'isTeacherOf.uri'                             => 'http://www.stork.gov.eu/1.0/isTeacherOf',
		'isTeacherOf.nameFormat'                      => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'isTeacherOf.value'                           => null,
		'isCourseCoordinator.name'                    => 'isCourseCoordinator',
		'isCourseCoordinator.uri'                     => 'http://www.stork.gov.eu/1.0/isCourseCoordinator',
		'isCourseCoordinator.nameFormat'              => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'isCourseCoordinator.value'                   => null,
		'isAdminStaff.name'                           => 'isAdminStaff',
		'isAdminStaff.uri'                            => 'http://www.stork.gov.eu/1.0/isAdminStaff',
		'isAdminStaff.nameFormat'                     => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'isAdminStaff.value'                          => null,
		'habilitation.name'                           => 'habilitation',
		'habilitation.uri'                            => 'http://www.stork.gov.eu/1.0/habilitation',
		'habilitation.nameFormat'                     => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'habilitation.value'                          => null,
		'acTitle.name'                                => 'acTitle',
		'acTitle.uri'                                 => 'http://www.stork.gov.eu/1.0/acTitle',
		'acTitle.nameFormat'                          => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'acTitle.value'                               => null,
		'hasDegree.name'                              => 'hasDegree',
		'hasDegree.uri'                               => 'http://www.stork.gov.eu/1.0/hasDegree',
		'hasDegree.nameFormat'                        => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'hasDegree.value'                             => null,
		'hasAccountInBank.name'                       => 'hasAccountInBank',
		'hasAccountInBank.uri'                        => 'http://www.stork.gov.eu/1.0/hasAccountInBank',
		'hasAccountInBank.nameFormat'                 => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'hasAccountInBank.value'                      => null,
		'isHealthCareProfessional.name'               => 'isHealthCareProfessional',
		'isHealthCareProfessional.uri'                => 'http://www.stork.gov.eu/1.0/isHealthCareProfessional',
		'isHealthCareProfessional.nameFormat'         => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'isHealthCareProfessional.value'              => null,

		'eLPIdentifier.name'                    => 'eLPIdentifier',
		'eLPIdentifier.uri'                     => 'http://www.stork.gov.eu/1.0/eLPIdentifier',
		'eLPIdentifier.nameFormat'              => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'eLPIdentifier.value'                   => null,
		'legalName.name'                        => 'legalName',
		'legalName.uri'                         => 'http://www.stork.gov.eu/1.0/legalName',
		'legalName.nameFormat'                  => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'legalName.value'                       => null,
		'alternativeName.name'                  => 'alternativeName',
		'alternativeName.uri'                   => 'http://www.stork.gov.eu/1.0/alternativeName',
		'alternativeName.nameFormat'            => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'alternativeName.value'                 => null,
		'type.name'                             => 'type',
		'type.uri'                              => 'http://www.stork.gov.eu/1.0/type',
		'type.nameFormat'                       => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'type.value'                            => null,
		'translatableType.name'                 => 'translatableType',
		'translatableType.uri'                  => 'http://www.stork.gov.eu/1.0/translatableType',
		'translatableType.nameFormat'           => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'translatableType.value'                => null,
		'status.name'                           => 'status',
		'status.uri'                            => 'http://www.stork.gov.eu/1.0/status',
		'status.nameFormat'                     => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'status.value'                          => null,
		'activity.name'                         => 'activity',
		'activity.uri'                          => 'http://www.stork.gov.eu/1.0/activity',
		'activity.nameFormat'                   => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'activity.value'                        => null,
		'registeredAddress.name'                => 'registeredAddress',
		'registeredAddress.uri'                 => 'http://www.stork.gov.eu/1.0/registeredAddress',
		'registeredAddress.nameFormat'          => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'registeredAddress.value'               => null,
		'registeredCanonicalAddress.name'       => 'registeredCanonicalAddress',
		'registeredCanonicalAddress.uri'        => 'http://www.stork.gov.eu/1.0/registeredCanonicalAddress',
		'registeredCanonicalAddress.nameFormat' => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'registeredCanonicalAddress.value'      => null,
		'contactInformation.name'               => 'contactInformation',
		'contactInformation.uri'                => 'http://www.stork.gov.eu/1.0/contactInformation',
		'contactInformation.nameFormat'         => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'contactInformation.value'              => null,
		'fiscalNumber.name'                     => 'fiscalNumber',
		'fiscalNumber.uri'                      => 'http://www.stork.gov.eu/1.0/fiscalNumber',
		'fiscalNumber.nameFormat'               => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'fiscalNumber.value'                    => null,
		'representative.name'                   => 'representative',
		'representative.uri'                    => 'http://www.stork.gov.eu/1.0/representative',
		'representative.nameFormat'             => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'representative.value'                  => null,
		'represented.name'                      => 'represented',
		'represented.uri'                       => 'http://www.stork.gov.eu/1.0/represented',
		'represented.nameFormat'                => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'represented.value'                     => null,
		'mandateContent.name'                   => 'mandateContent',
		'mandateContent.uri'                    => 'http://www.stork.gov.eu/1.0/mandateContent',
		'mandateContent.nameFormat'             => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'mandateContent.value'                  => null,
	);

	public static $countries = array( 'ES' );

	public static function genAttrs( $request ) {
		$extensions = array();

		//extensions
		$extensions['stork:QualityAuthenticationAssuranceLevel'] = array_key_exists( 'qaaLevel', $request ) ? $request['qaaLevel'] : 3;

		$extensions['stork:spCountry'] = $request['spcountry'];

		$confs = self::get_confs();
		foreach ( $confs as $key => $value ) {
			$extensions[ $key ] = $value;
		}

		//vidp
		$extensions['VIDP'] = array(
			'country' => $request['country'],
			'spid'    => StorkConstants::get_spname(),
		);

		//requested attributes
		$attributes = array();

		foreach ( self::$idsPersonal as $key ) {

			$found = 0;
			if ( $request[ $key . 'Type' ] === 'true' ) {
				$found      = 1;
				$attrStatus = 'true';
			} else if ( $request[ $key . 'Type' ] === 'false' ) {
				$found      = 1;
				$attrStatus = 'false';
			}
			if ( $found ) {
				if ( array_key_exists( $key . 'Value', $request ) ) {
					$attrValue = $request[ $key . 'Value' ];
				} else {
					$attrValue = self::$attrs[ $key . '.value' ];
				}
				$ra = new RequestedAttribute( 'stork', 'RequestedAttribute', self::$attrs[ $key . '.name' ], self::$attrs[ $key . '.nameFormat' ], $attrStatus, $attrValue );
				array_push( $attributes, $ra );
			}
		}

		if ( ! empty( $attributes ) ) {
			$extensions['RequestedAttributes'] = $attributes;
		}

		return $extensions;
	}

	//Igual que genAttrs, pero para el botón de "Lanzar petición"
	public static function genDefaultAttrs( $request ) {

		$settings = get_option( M4P_EXTERNALS_LOGIN_SETTINGS );

		$qaaLevel = isset( $settings['qaaLevel'] ) === true ? $settings['qaaLevel'] : '3';


		$extensions = array();

		//extensions
		$extensions['stork:QualityAuthenticationAssuranceLevel'] = array_key_exists( 'qaaLevel', $request ) ? $request['qaaLevel'] : $qaaLevel;

		$extensions['stork:spCountry'] = $request['spcountry'];

		$confs = self::get_confs();
		foreach ( $confs as $key => $value ) {
			$extensions[ $key ] = $value;
		}

		//vidp
		$extensions['VIDP'] = array(
			'country' => $request['country'],
			'spid'    => StorkConstants::get_spname(),
		);

		//requested attributes
		$attributes = array();

		$request['DNIType']       = 'true';
		$request['NombreType']    = 'true';
		$request['ApellidosType'] = 'true';
		$request['eMailType']     = 'true';

		foreach ( self::$idsPersonal as $key ) {

			$found = 0;
			if ( isset( $request[ $key . 'Type' ] ) ) {
				if ( $request[ $key . 'Type' ] === 'true' ) {
					$found      = 1;
					$attrStatus = 'true';
				} else if ( $request[ $key . 'Type' ] === 'false' ) {
					$found      = 1;
					$attrStatus = 'false';
				}
			}
			if ( $found ) {
				if ( array_key_exists( $key . 'Value', $request ) ) {
					$attrValue = $request[ $key . 'Value' ];
				} else {
					$attrValue = self::$attrs[ $key . '.value' ];
				}
				$ra = new RequestedAttribute( 'stork', 'RequestedAttribute', self::$attrs[ $key . '.name' ], self::$attrs[ $key . '.nameFormat' ], $attrStatus, $attrValue );
				array_push( $attributes, $ra );
			}
		}

		if ( ! empty( $attributes ) ) {
			$extensions['RequestedAttributes'] = $attributes;
		}

		return $extensions;
	}


	/***************************************
	 *      FUNCIONES PARA WordPress
	 *************************************+*/


	/**
	 *
	 * Esta función reemplazará a la constante SPID, así, las referencias a
	 * StorkConstants::SPID pasan a ser StorkConstants::get_spname()
	 *
	 * demo: demo-sp-php
	 *
	 * @return string
	 */
	public static function get_spname() {
		$options = get_option( M4P_EXTERNALS_LOGIN_SETTINGS );

		return $options['spname'];
	}

	/**
	 *
	 * Esta función reemplazará a la constante ASSERTION_URL, así, las referencias a
	 * StorkConstants::ASSERTION_URL pasan a ser StorkConstants::getAssertionUrl()
	 *
	 * @return string
	 */
	public static function getAssertionUrl() {

		$redirect = urldecode( $_SERVER['HTTP_REFERER'] );

		$params = parse_url( $redirect, PHP_URL_QUERY );

		if ( false !== strstr( $params, 'redirect_to' ) ) {
			$new_params = '?external_logged=ok';
		} else {
			$new_params = '?external_logged=ok&redirect_to=' . $redirect;
		}

		return wp_login_url() . $new_params;
	}

	/**
	 *
	 * Esta función reemplazará a la constante LOGOUT_RETURN_URL, así, las referencias a
	 * StorkConstants::LOGOUT_RETURN_URL pasan a ser StorkConstants::getLogoutReturnUrl()
	 *
	 * @return string
	 */
	public static function getLogoutReturnUrl() {

		$redirect = urldecode( $_SERVER['HTTP_REFERER'] );

		$params = parse_url( $redirect, PHP_URL_QUERY );

		if ( false !== strstr( $params, 'redirect_to' ) ) {
			$new_params = '?logout=ok';
		} else {
			$new_params = '?logout=ok&redirect_to=' . $redirect;
		}

		return wp_login_url() . $new_params;
	}

	/**
	 *
	 * Esta función reemplazará a la constante LOGOUT_SEND_URL, así, las referencias a
	 * StorkConstants::LOGOUT_SEND_URL pasan a ser StorkConstants::get_logout_send_url()
	 *
	 * demo: https://se-pasarela.clave.gob.es/Proxy/LogoutAction
	 *
	 * @return string
	 */
	public static function get_logout_send_url() {
		$options = get_option( M4P_EXTERNALS_LOGIN_SETTINGS );

		return $options['logout_send_url'];
	}

	/**
	 * demo: https://se-pasarela.clave.gob.es/Proxy/ServiceProvider
	 * @return string
	 */
	public static function get_login_send_url() {
		$options = get_option( M4P_EXTERNALS_LOGIN_SETTINGS );

		return $options['login_send_url'];
	}

	/**
	 * @return string
	 */
	public static function getCertDirectoryPath() {
		$options = get_option( M4P_EXTERNALS_LOGIN_SETTINGS );

		return $options['cert_directory_path'];
	}

	public static function logEnabled() {
		$options = get_option( M4P_EXTERNALS_LOGIN_SETTINGS );

		return $options['enable_log'] === 'enable' ? true : false;
	}

	public static function getLogPath() {
		$options = get_option( M4P_EXTERNALS_LOGIN_SETTINGS );

		return $options['log_path'];
	}

	public static function logLevel() {
		$options = get_option( M4P_EXTERNALS_LOGIN_SETTINGS );

		return (int) $options['log_level'];
	}

	public static function get_confs() {
		$spid  = self::get_spname();
		$confs = array(
			'stork:spSector'             => $spid,
			'stork:spInstitution'        => $spid,
			'stork:spApplication'        => $spid,
			'storkp:eIDSectorShare'      => 'true',
			'storkp:eIDCrossSectorShare' => 'true',
			'storkp:eIDCrossBorderShare' => 'true',
		);

		return $confs;
	}


}
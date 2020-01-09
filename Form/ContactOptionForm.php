<?php

namespace ContactOptionBuilder\Form;

use ContactOptionBuilder\Model\ContactOptionFormBuider;
use ContactOptionBuilder\Model\ContactOptionFormBuiderQuery;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;
class ContactOptionForm extends BaseForm
{
    protected function buildForm()
    {
        $this->formBuilder
            ->add('name', 'text', array(
                'constraints' => array(
                    new NotBlank(),
                ),
                'label' => Translator::getInstance()->trans('Full Name'),
                'label_attr' => array(
                    'for' => 'name_contact',
                ),
            ))
            ->add('email', 'email', array(
                'constraints' => array(
                    new NotBlank(),
                    new Email(),
                ),
                'label' => Translator::getInstance()->trans('Your Email Address'),
                'label_attr' => array(
                    'for' => 'email_contact',
                ),
            ))
            ->add(
                'contact_subject',
                ChoiceType::class, [
                    'label' => Translator::getInstance()->trans("Contact mail subject"),
                    'label_attr' => array(
                        'for' => 'contact_subject'
                    ),
                    'choices' => $this->getAllSubject(),
                ]
            )
            ->add('message', 'text', array(
                'constraints' => array(
                    new NotBlank(),
                ),
                'label' => Translator::getInstance()->trans('Your Message'),
                'label_attr' => array(
                    'for' => 'message_contact',
                ),

            ))
            ->add(
                'order',
                TextType::class, [
                    'label' => Translator::getInstance()->trans("Your order"),
                    'label_attr' => array(
                        'for' => 'order'
                    ),
                    'required'=> false
                ]
            )
            ->add(
                'company_name',
                TextType::class, [
                    'label' => Translator::getInstance()->trans("Company Name"),
                    'label_attr' => array(
                        'for' => 'company_name'
                    ),
                    'required'=> false
                ]
            );
    }

    public function getAllSubject()
    {
        $subjects = ContactOptionFormBuiderQuery::create()
                        ->find();

        $data =[];

        /** @var ContactOptionFormBuider $subject */
        foreach ($subjects as $subject){
            $data[$subject->getIdCofb()] = $subject->getSubjectCofb();
        }

        return $data;
    }

    public function getName()
    {
        return "contact_option_builder_subject";
    }
}
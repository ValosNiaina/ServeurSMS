<?php

namespace App\Form;

use App\Entity\Message;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Contact;

class MessageForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('contenu')
            ->add('envoyer')
            ->add('dateMessage')
            ->add('contact', EntityType::class, [
                'class' => Contact::class, // Le nom de votre entité Contact
                'choice_label' => 'nom',   // Le champ à afficher dans la liste déroulante (supposons que 'nom' soit une propriété de l'entité Contact)
                // Vous pouvez ajouter d'autres options selon vos besoins
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}

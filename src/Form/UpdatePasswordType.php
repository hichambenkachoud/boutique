<?php
/**
 * @author BEN KACHOUD Hicham <h.benkachoud.im@gmail.com>
 */

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdatePasswordType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
      $builder
          ->add('old_password', PasswordType::class, [
              'label' => 'Mot de passe actuel',
              'mapped' => false,
              'attr' => [
                  'placeholder' => 'Saisir votre mot de passe actuel'
              ]
          ])
          ->add('new_password', RepeatedType::class, [
              'type' => PasswordType::class,
              'mapped' => false,
              'invalid_message' => 'Les mots de passe ne sont pas identiques',
              'options' => ['attr' => ['class' => 'password-field']],
              'required' => true,
              'first_options'  => [
                  'label' => 'Mot de passe',
                  'attr' => [
                      'placeholder' => 'Saisir votre mot de passe'
                  ]
              ],
              'second_options' => [
                  'label' => 'Confirmation de mot de passe',
                  'attr' => [
                      'placeholder' => 'Saisir votre confirmation de mot de passe'
                  ]
              ],
          ])
          ->add('submit', SubmitType::class, [
              'label' => 'Modifier'
          ])
          ;
  }

  public function configureOptions(OptionsResolver $resolver)
  {
      $resolver->setDefault('data_class', User::class);
  }
}
<?php

namespace App\Form\Event;

use App\Entity\Event;
use App\Form\ApiForm;
use App\Model\Event\CreateEventModel;
use App\Validator\EventCategory\EventCategoryConstraint;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Context\ExecutionContext;

class CreateForm extends ApiForm
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('title', TextType::class, [
                'constraints' => [
                    new NotNull(),
                    new Length(min: 3),
                ],
            ])
            ->add('date', DateTimeType::class, [
                'widget' => 'single_text',
                'constraints' => [
                    new NotNull(),
                ],
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [Event::TYPE_ONLINE, Event::TYPE_LOCAL],
            ])
            ->add('categories', CollectionType::class, [
                'entry_type' => TextType::class,
                'allow_add' => true,
                'constraints' => [
                    new Count(['min' => 1]),
                    new All([
                        new NotNull(),
                    ]),
                    new EventCategoryConstraint(),
                ],
            ])
            ->add('participationTerms', TextType::class)
            ->add('details', TextType::class)
            ->add('avatar', FileType::class, [
                'constraints' => [
                    new NotNull(),
                ],
            ])
            ->add('countMembersMax', IntegerType::class)
            ->add('timeZone', TextType::class, [
                'constraints' => [
                    new NotNull(),
                ],
            ])
            ->add('longitude', NumberType::class, [
                'constraints' => [
                    new Range(['min' => -180, 'max' => 180]),
                ],
            ])
            ->add('latitude', NumberType::class, [
                'constraints' => [
                    new Range(['min' => -90, 'max' => 90]),
                ],
            ])
            ->add('city', TextType::class)
            ->add('street', TextType::class)
            ->add('streetNumber', TextType::class)
            ->add('placeName', TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $checkLocation = function ($value, ExecutionContext $context) {
            if (Event::TYPE_LOCAL === $value->getType()
                && (null === $value->getLatitude()
                    || null === $value->getLongitude()
                    || null === $value->getCity()
                    || null === $value->getStreet()
                    || null === $value->getStreetNumber()
                )) {
                $context
                    ->buildViolation('Для локального мероприятия необходимо указать все данные места проведения')
                    ->atPath('location')
                    ->addViolation();
            }
        };

        parent::configureOptions($resolver);
        $resolver
            ->setDefaults([
                'data_class' => CreateEventModel::class,
                'constraints' => [
                    new Callback($checkLocation),
                ],
            ]);
    }
}

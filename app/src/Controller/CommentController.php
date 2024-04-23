<?php

/**
 * Comment controller.
 */

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Repository\CommentRepository;
use App\Form\Type\CommentType;
use App\Form\Type\DeleteCommentType;
use App\Service\CommentServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class CommentController.
 */
#[Route('/comment')]
class CommentController extends AbstractController
{
    /**
     * Comment Repository.
     */
    private CommentRepository $commentRepository;

    /**
     * Comment service.
     */
    private CommentServiceInterface $commentService;

    /**
     * Translator interface.
     */
    private TranslatorInterface $translator;

    /**
     * Constructor.
     *
     * @param CommentRepository       $commentRepository Comment repository
     * @param CommentServiceInterface $commentService    Comment service
     * @param TranslatorInterface     $translator        Translator
     */
    public function __construct(CommentRepository $commentRepository, CommentServiceInterface $commentService, TranslatorInterface $translator)
    {
        $this->commentRepository = $commentRepository;
        $this->commentService = $commentService;
        $this->translator = $translator;
    }

    /**
     * Create action.
     *
     * @param Request $request HTTP request
     * @param Post    $post    Post
     *
     * @return Response HTTP response
     */
    #[Route(
        '/create',
        name: 'comment_create',
        methods: 'GET|POST',
    )]
    public function create(Request $request, Post $post): Response
    {
        $comment = new Comment();
        $comment->setPost($post);
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->commentService->save($comment);

            return $this->redirectToRoute('post_index');
        }

        return $this->render(
            'comment/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Delete action.
     *
     * @param Request $request HTTP request
     * @param Comment $comment Comment entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/delete', name: 'comment_delete', requirements: ['id' => '[1-9]\d*'], methods: 'GET|DELETE')]
    public function delete(Request $request, Comment $comment): Response
    {
        $form = $this->createForm(DeleteCommentType::class, $comment, [
            'method' => 'DELETE',
            'action' => $this->generateUrl('comment_delete', ['id' => $comment->getId()]),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->commentService->delete($comment);

            $this->addFlash(
                'success',
                $this->translator->trans('message.comment_deleted')
            );

            return $this->redirectToRoute('post_index');
        }

        return $this->render(
            'comment/delete.html.twig',
            [
                'form' => $form->createView(),
                'comment' => $comment,
            ]
        );
    }
}
